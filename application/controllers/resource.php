<?php
class Resource extends CI_Controller {


	function Resource()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('RESOURCE');
		# Load URL and form helper classes	
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> helper('date');
		$this->load->model('ResourceDB_model');
		$this->load->model('Edit_model');
		# Load form validation library
		$this->load->library('form_validation');
		# Turn on profiling for debugging
		//$this->output->enable_profiler(TRUE);

	}

	# Index function called by default on controller load
	# Resource DB home
	function index()
	{
		$data['title'] = 'Global Health repository: resources';
        $data['heading'] = 'Welcome';
		$this->load->view('resourcedb/homeview', $data);
	}
	

	
	/**
	* Compare two sets of subjects in arrays
	* Compare existing subjects attached to a resource, with those the
	* user's selected in the subjects list, and return any subjects in the 
	* old list that aren't in the new list. Called from edit function. 
	* NB: comparison is of subject IDs, as user can't create new subjects as
	* s/he can with tags 
	* @param mixed $old_subjects_ary Array of names of existing subjects
	* @param mixed $new_subjects_ary Array of names of user-specified subjects
	* @return mixed Array of tagnames in old tags that are absent in new subjects
	*/
	function compare_subjects($old_subjects_ary, $new_subjects_ary)
	{
		$detached_subjects = array();
		foreach ($old_subjects_ary as $key => $val)
		{
			if (!(in_array($key, $new_subjects_ary)))
			{
				$detached_subjects[] = $key;
			}
		}
		return $detached_subjects;
	}
	
	/* -------- INSERT ---------- */
	# Insert resource record
	function insert()
	{
	
		# Check that user has sufficient rights to insert, else redirect
		# Although the Insert item only appears in the menu for contributors and admins, 
		# user could reach it from URL editing
		# TO DO: either display unauthorised message on home page, or create new 'unauthorised' view
		# and load that. 
		if (! ( ($this->ion_auth->is_admin()  || $this->ion_auth->in_group('contributor')) ) ) 
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');
    	}
		
		# Get the user ID to save as record editor
		$user_id = $this->ion_auth->user()->row() -> id;
		# Set user message and error as blanks, to prevent PHP warning if one or t'other isn't set
		$data['message'] = ""; $data['error'] = "";
		
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: add resource";
		$data['heading'] = "Add resource"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Add resource"; // active menu item
		$data['active_submenu'] = "Add"; 
	
		
		# Populate form elements. 
		# Call function in ResourceDB_model to get subject areas
		# False param indicates that all subjects should be returned, not just those 'in use'
		# by existing resources
		//$data['subjects_query'] = $this -> ResourceDB_model -> get_subjects(false);
				# Get key areas (aka top level categories) and shove into an array
		# Query returns * in key_areas table (id, title, description)
		$data['keyarea_query'] = $this -> ResourceDB_model -> get_key_areas();
		# Origin not used in Global Health repository
		//$data['origins_query'] = $this -> ResourceDB_model -> get_origins();
		# Note parameter in function call - this will return all types, not just those 'in use', 
		# which is important for an insert form.
		$data['resource_types_query'] = $this -> ResourceDB_model -> get_resource_types(FALSE);
		
		# ==== FORM VALIDATION ======
		# Note that set_value() to repopulate the form *only* works on elements with 
		# validation rules, hence a rule for all elements below. See CI Forum thread at:
		# http://codeigniter.com/forums/viewthread/170221/
		# Custom rule to check on unique resource title
		# NB: no longer using callback function, preferring the is_unique validation option, 
		# though I've left the function title_check() in this class below
		$this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean|is_unique[gh_resource.title]');
		$this->form_validation->set_rules('url', 'URL', 'required|trim|xss_clean|prep_url');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		$this->form_validation->set_rules('subjects', 'Subjects', 'required');		
		$this->form_validation->set_rules('tags', 'Tags', 'trim|xss_clean');
		$this->form_validation->set_rules('rights', 'Rights', 'trim|xss_clean');		
		$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean');		
		$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean');		
		
		# If the form doesn't validate, or indeed hasn't even been submitted, 
		# (re)populate with user data
		if ($this->form_validation->run() == FALSE)
		{
			$data ['error'] = validation_errors();	
			# Fill page template - template view called at function end
			$template['content'] = $this -> load -> view('resource/insert_view', $data, TRUE);

		}
		# If form validates, insert record
		else
		{
			# Get form values for fields in RESOURCE table
			# What's the current date and time? Use the date helper - 
			# now() returns current time as Unix timestamp, unix_to_human
			# converts it to YYYY-MM-DD HH:MM:SS which mySQL needs for the 
			# DATETIME data type
			$now = 	unix_to_human(now(), TRUE, 'eu'); // Euro time with seconds

			$record_data = array (
							'title' => $_POST['title'], 
							'url' => $_POST['url'], 
							'description' => $_POST['description'], 
							'type' => $_POST['type'], 
							'author' => $_POST['author'], 
							'rights' => $_POST['rights'], 
							'restricted' => $_POST['restricted'], 
							'visible' => $_POST['visible'], 
							'metadata_created' => $now, 
							'metadata_modified' => $now, 
							'metadata_author' =>  $user_id, 
							'notes' => $_POST['notes']			
							);
							
			$result = $this -> Edit_model -> insert_resource($record_data);	
			# If insert failed, tell user then quit
			if (!$result)
			{ 
				$data['error'] = "There was an error inserting into the RESOURCE table. Bummer.
								Here it is: <br />" . mysql_error(); 
				$data['title'] = "Database error"; 
				$data['heading'] = "Database error";
				# Load the Database error view
				$this -> load -> view ('resource/database_error_view', $data);
				//exit; 
			}	
			# ...but if it worked set flag to true and store new resource id
			else 
			{ 
				$resource_id = $result;
			}				
			
			# ======== JUNCTION TABLES ==========
			# Now get form values for fields using junction tables				
			$this->load->helper('security'); // for xss_clean()
			# TAGS
			# First, get tag(s) user's inserted. 
			$tags = $_POST['tags'];
			# ...then split string by the comma delimiter...
			$tags_ary = explode(',', $tags);
			# ...then remove any duplicate tags...			
			$tags_ary = array_unique($tags_ary);
			# ...then go through tags and attach to the resource, 
			# adding new tags to KEYWORDS if not already exist
			foreach ($tags_ary as $key => $val)
			{
				# Remove any white space from the tag, and if that leaves an
				# empty element (eg if user's typed ;;, or ;   ; or similar)
				# then remove it from the array 
				$val = trim($val);
				if (empty($val))
					{ unset($tags_ary[$key]); }
				# Now check if the tag already exists in the KEYWORD table, and if not add it
				$q = $this -> ResourceDB_model -> get_tag_id($val);  
				# If it's not there add it to the KEYWORD table and get the new ID
				if ($q -> num_rows() == 0)
				{
					# Get ID of inserted tag
					$tag_id = $this -> Edit_model -> add_tag($val);
				}
				# If tag's already in KEYWORD, just get its ID
				else
				{
					# Get ID of existing tag
					$tag_id = $q -> row() -> id;	
				}
				# Now put the tag ID in to the junction table with the resource ID
				$this -> Edit_model -> attach_tag($resource_id, $tag_id);
			}
			
			# SUBJECTS
			# The input form lists subjects as a series of checkboxes with the name
			# subjects[] which generates an array in POST, so go through that array, 
			# if it exists (if the user's checked a subject), and 'attach' subjects to 
			# the resource in RESOURCE_SUBJECT junction table
			if (isset($_POST['subjects']))
			{
				$subjects = $_POST['subjects'];
				foreach ($subjects as $key => $val)
				{
					$this -> Edit_model -> attach_subject($resource_id, $val);	
				}
			}
			
			# Set messages etc for the result page
			$data['title'] = "Add resource: result";
			$data['heading']  = "Add resource: result";
			$data['resource_title'] = $record_data['title'];
			$data['resource_id'] = $resource_id; 
		 	$data['message'] = 'Record inserted ok'; 	

			# Load results page with data array
			$template['content'] = $this -> load -> view('resource/insert_result_view', $data, TRUE);

		} // end if validates
		
			$this -> load -> view ('template2_view', $template);	
			# Add form validation script
			$this -> load -> view('resource/resource_validation_script_view');
			# Load TinyMCE editor
			$this -> load -> view('tinymce_script_view');	
			# Load jQuery tag plugin for pretty tag display and editing
			$this -> load -> view('resource/tag_plugin_view');
			# Load script for Ajax title check
			$this -> load -> view('resource/titlecheck_script_view');

	} // end insert function

	/* -------------- SUGGEST --------------- */
	/**
	* Load form to allow contributor to suggest a resource
	* The form calls a form to email script to email an admin. 
	* Only visible to logged-in contributors
	* @return void	
	*/
	function suggest()
	{
		
		if (! ( ($this->ion_auth->is_admin()  || $this->ion_auth->in_group('contributor') ) ) ) 
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');
    	}
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: suggest a resource";
		$data['heading'] = "Suggest a resource"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Suggest"; // active menu item
		$data['active_submenu'] = "Suggest"; 
		$template['content'] = $this -> load -> view('resource/suggest_resource_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);	
		# add extra form validation JS after footer
		$this -> load -> view('forms/validation_script_view');	
		# Load TinyMCE editor
		$this -> load -> view('tinymce_script_view');		
	}
	
	/**
	* Callback function for insert form validation
	* Checks that unique title has been supplied. 
	* @param string $str Title to be checked for uniqueness
	* @return boolean True if the title is unique, else false
	* DEPRECATED in favour of is_unique validation parameter, but kept just in case
	*/
	/* function title_check($str)
	{
		# Query in model to search for record with the supplied title
		$qry = $this -> ResourceDB_model -> get_title($str);
		if ($qry -> num_rows() > 0)
		{
			$this->form_validation->set_message('title_check', 'This title is already in the repository. Please choose another.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}	
	}
	*/
	
/* ---------------------- EDIT --------------------- */
	/**
	* Update existing resource record in RESOURCE table
	* and related tables (keyword) and junction tables. 
	* @param int $resource_id ID of resource to edit
	*/
	
	function choose()
	{
		if (! ( ($this->ion_auth->is_admin()  || $this->ion_auth->in_group('contributor') ) ) ) 
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');
    	}
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: edit resource";
		$data['heading'] = "Edit resource"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Edit resource"; // active menu item
		$data['active_submenu'] = "Edit"; 
		//$data['resource_query'] = $this -> ResourceDB_model -> get_resources();
		$data['title'] = "Choose resource to edit";
		$data['heading'] = "Choose resource to edit";
		# If ordinary contributor (not admin) only display non-restricted visible records...
		if ( (! $this -> ion_auth -> is_admin() ) && ($this->ion_auth->in_group('contributor')) )
		{
			$data['resource_query'] = $this -> ResourceDB_model -> get_public_resources();
		}
		# ...otherwise display the lot
		else
		{
			$data['resource_query'] = $this -> ResourceDB_model -> get_resources();
		}
		# Get 10 most recently edited records for display
		$data['recently_edited'] = $this -> ResourceDB_model -> get_public_resources(10, "metadata_modified desc");
		$template['content'] = $this -> load -> view('resource/edit_choose_view', $data, TRUE);
		$this -> load -> view ('template2_view', $template);
		$this -> load -> view ('resource/edit_choose_autocomplete_view');
	}
	
	
	function edit($resource_id=NULL)
	{
		# Check that user has sufficient rights to edit, else redirect
		# Although the Edit item only appears in the menu for contributors and admins, 
		# user could reach it from URL editing
		// echo $this -> uri -> segment(2);
		if (! ( ($this->ion_auth->is_admin()  || $this->ion_auth->in_group('contributor') ) ) ) 
		{
    		# redirect them to the home page 
			# TO DO: redirect to a page with a message saying that they're not a contributor
			redirect('home', 'refresh');
    	}
		
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: edit resource";
		$data['heading'] = "Edit resource"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Edit resource"; // active menu item
		$data['active_submenu'] = "Edit"; 
		$data['message'] = "";
		$data['error'] = "";
		
		# If a resource has been chosen in the editchooseview view, the ID will
		# be passed in POST, so get it then re-call this controller, invoking 
		# the resource method with the ID
		if (isset($_POST['resource_id']))
		{
			$resource_id = $_POST['resource_id'];
			redirect("resource/edit/$resource_id", 'refresh');
		}
		# ...else if there's a resource_id in the URL, display the edit form
		# for that resource. If the segment doesn't exist FALSE is returned.
		elseif (is_null($resource_id))
		{
			redirect("resource/choose/", 'refresh');
		}
		# If nowt in POST, just display the choose resource to edit view
		else
		{

		}
		
		# Call model function to get resource record
		$q = $this -> ResourceDB_model -> get_resource_detail($resource_id);
		$resource_title = $q -> row() -> title;
		$data['resource__id'] = $resource_id; 
		# Get the user ID to save as record editor
		$user_id = $this->ion_auth->user()->row()-> id;		
		# Populate form elements.
		# Get full resource record first 
		$data['resource_detail_query'] = $this -> ResourceDB_model -> get_resource_detail($resource_id);
		
		
		# -- SUBJECTS ---
		# Get all subjects in the database, to display in the 'subjects' <div> in the view
		# False param indicates that all subjects should be returned, not just those 'in use'
		# by existing resources
		$data['subjects_query'] = $this -> ResourceDB_model -> get_subjects(false);
		# Get subjects attached to this resource, if any. These will be selected in the view
		$attached_subjects_query =  $this -> ResourceDB_model -> get_resource_subjects($resource_id);
		$old_subjects_ary = array();
		# Create 2-D array, subject IDs as keys, subject titles as values
		foreach ($attached_subjects_query -> result() as $row)
		{
			$old_subjects_ary[$row -> id] = $row -> title;
		}
		# Pass currently attached subjects to the view page
		$data['attached_subjects_ary'] = $old_subjects_ary;	
		
		# -- RESOURCE TYPES ---
		# False param returns all resource types, not just those 'in use'
		$data['resource_types_query'] = $this -> ResourceDB_model -> get_resource_types(false);
		
		# -- TAGS --
		# Get all tags attached to this resource, both to use in the view and in this script
		# Note: only tag names stored as IDs aren't used in this script or the view
		$tags_query = $this -> ResourceDB_model -> get_resource_tags($resource_id);
		$old_tags_ary = array();
		foreach ($tags_query -> result() as $row)
		{
			$old_tags_ary[] = $row -> name;	
		}
		$data['tags_ary'] = $old_tags_ary; 
		
		# ==== FORM VALIDATION ======
		# Note that set_value() to repopulate the form *only* works on elements with 
		# validation rules, hence a rule for all elements below. See CI Forum thread at:
		# http://codeigniter.com/forums/viewthread/170221/

		# NB: The callback function to check the title has the existing title as a 'parameter' in 
		# sqare brackets, as just checking for the title existing would always 
		# return true - we need to check that the edited title exists or not. 
		$this->form_validation->set_rules('title', 'Title', "required|trim|xss_clean");
		$this->form_validation->set_rules('url', 'URL', 'required|trim|xss_clean|prep_url');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		$this->form_validation->set_rules('tags', 'Tags', 'trim|xss_clean');
		$this->form_validation->set_rules('subjects', 'Categories', 'required');		
		$this->form_validation->set_rules('creator', 'Creator', 'trim|xss_clean');
		$this->form_validation->set_rules('rights', 'Rights', 'trim|xss_clean');		
		$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean');	
		# If the form doesn't validate, or indeed hasn't even been submitted, 
		# (re)populate with user data
		if ($this->form_validation->run() == FALSE)
		{
			$data ['error'] = validation_errors();	
			# Load page data into template - the view will be called at function end
			$template['content'] = $this -> load -> view('resource/edit_view', $data, TRUE);
		}	

		# If form validates, update record
		else
		{
			# Get form values for fields in gh_resource table
			# What's the current date and time? Use the date helper - 
			# now() returns current time as Unix timestamp, unix_to_human
			# converts it to YYYY-MM-DD HH:MM:SS which mySQL needs for the 
			# DATETIME data type
			$now = 	unix_to_human(now(), TRUE, 'eu'); // Euro time with seconds

			$record_data = array (
							'title' => $_POST['title'], 
							'url' => $_POST['url'], 
							'description' => $_POST['description'], 
							'type' => $_POST['type'], 
							'author' => $_POST['author'], 
							//'source' => $_POST['source'],  
							'rights' => $_POST['rights'], 
							'restricted' => $_POST['restricted'], 
							'visible' => $_POST['visible'], 
							'metadata_modified' => $now, 
							'metadata_author' =>  $user_id, 
							'notes' => $_POST['notes']			
							);
							
			
			# Run update query in model
			$this -> Edit_model -> update_resource($record_data, $resource_id);	
			# ======== JUNCTION TABLES ==========
			# Now get form values for fields using junction tables				

			# TAGS
			# First, get tag(s) user's inserted. 
			if (!empty($_POST['tags']))
			{
				$tags = $this -> input -> post('tags');

				# ...then split string by the comma delimiter...
				$tags_ary = explode(',', $tags);
				# ...then remove any duplicate tags...			
				$tags_ary = array_unique($tags_ary);
				# ...then see if the user's removed any existing tags.
				$detached_tags_ary = $this -> compare_tags($old_tags_ary, $tags_ary);
				# Detach the tags removed from resource 
				# (deleting rows in the RESOURCE_KEYWORD junction table)
				foreach($detached_tags_ary as $key => $val)
				{
					# Get id of tag to detach
					$q = $this -> ResourceDB_model -> get_tag_id($val);
					$tag_id = $q -> row() -> id;
					$this -> Edit_model -> detach_tag($resource_id, $tag_id);
				}
				# Go through user-entered tags and attach to the resource, 
				# adding new tags to KEYWORDS if not already exist
				$this -> attach_tags($tags_ary, $resource_id);
			}
			
			# SUBJECTS
			# The input form lists subjects as a series of checkboxes with the name
			# subjects[] which generates an array in POST, so go through that array
			# and 'attach' subjects to the resource in RESOURCE_SUBJECT junction table
			# First, check that any subjects are checked at all, and if not just create an 
			# empty array so as not to generate a runtime error
			if (isset($_POST['subjects']))
			{   $subjects_id_ary = $_POST['subjects']; }
			else
			{   $subjects_id_ary = array(); }
			# Get an array of the IDs of subjects to detach
			$detached_subjects_id_ary = $this -> compare_subjects($old_subjects_ary, $subjects_id_ary);
			foreach ($detached_subjects_id_ary as $key => $val)
			{
				$this -> Edit_model -> detach_subject($resource_id, $val);	
			}

			foreach ($subjects_id_ary as $val)
			{
				# The model function checks if subject already attached
				$this -> Edit_model -> attach_subject($resource_id, $val);	
			}

			
			# Set messages etc for the result page
			$data['title'] = "Edit resource: result";
			$data['heading']  = "Edit resource: result";
			$data['resource_title'] = $record_data['title'];
			$data['resource_id'] = $resource_id; 
			$data['message'] = 'Record edited ok'; 	
			# Load results page with data array
			$template['content'] = $this->load->view('resource/edit_result_view', $data, TRUE);		
		} // end if validates	
		
		# Display form or update results
		$this -> load -> view ('template2_view', $template);
		# Load TinyMCE editor
		$this -> load -> view('tinymce_script_view');	
		# Load tag plugin script
		$this -> load -> view('resource/tag_plugin_view');
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this resource record? You cannot undo this action.\"";
		$this -> load -> view('confirm_script_view', $script_data);
		
		
	} // end edit function
	
	

	/* ------------ DETAIL ------------ */
	/**
	* Display a full resource record
	* @param int $resource_id ID of resource, passed in URL
	*/
	function detail($resource_id)
	{
		$data['title'] = 'Resource DB: record detail';
        $data['heading'] = 'Resource DB: record detail';
		$data['query'] = $this -> ResourceDB_model -> get_resource_detail($resource_id);
		$this->load->view('resourcedb/recordview', $data);
	}
	
	/**
	* List resource titles by tag or subject.
	* Also get the subject or tag name for display in a 'browse results' page
	* @param string $type Values: 'tag', 'subject'
	* @param int $id Primary key from KEYWORD or SUBJECT
	*/
	function list_titles($type, $id)
	{
		if ($type == "tag")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('tag', $id, 'title');
			$qry = $this -> ResourceDB_model -> get_tag_record($id);
			$row = $qry -> row();
			$title = $row -> keyword_name;
		}
		if ($type == "subject")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('subject', $id, 'title');
			$qry = $this -> ResourceDB_model -> get_subject_record($id);
			$row = $qry -> row();
			$title = $row -> title;
		}
		if ($type == "type")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('type', $id, 'title');
			$qry = $this -> ResourceDB_model -> get_type_record($id);
			$row = $qry -> row();
			$title = $row -> title;			
			
		}
		$data['title'] = 'Resource DB: browse by ' . $type . " \"" . $title . "\"";
		$data['heading'] = 'Resource DB: browse by ' . $type . " \"" . $title . "\"";
		$this->load->view('resourcedb/listview', $data);
	}
	

	function search()
	{
		$data['title'] = 'Resource DB: search';
        $data['heading'] = 'Resource DB: search';
		if (isset($_POST['search_term']))
		{
			$data['query'] = $this -> ResourceDB_model -> search_title($_POST['search_term']);
		}
		$this->load->view('resourcedb/searchview', $data);

	}
	
	/* ---------------- DELETE -------------- */
	
	/**
	* Delete a resource record
	* This is a permanent deletion
	* TO DO: delete any file (eg a doc) associated with the record
	* @param int $resource_id ID of resource to be deleted
	*/
	function delete($resource_id)
	{
		# If user's not an admin, see them off
		if (! ($this->ion_auth->is_admin() ) ) 
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');
    	}

		 if (!$this -> ResourceDB_model -> delete_resource($resource_id))
		 {
			$message = "This resource could not be deleted. Bummer.";
		 }
		 else
		{
			$message = "The resource has been deleted for good. ";
		}
		# Set flashdata message to display on resource admin page
		$this->session->set_flashdata('message', $message);
		# redirect them to the resource admin page 
		redirect('admin/resources', 'refresh');

	}
	
	/* ---------- TITLE CHECK --------------- */
	/**
	* Check if a title exists in the resource table.
	* Called by jQuery code in resource/insert_view, which picks up a click on the "Check title" button. 
	* The script sends an Ajax request, and the response is the echoed string below. 
	* @return void	
	*/
	function title_check()
	{
		$title = $this -> input -> post('title');
		$resource_qry = $this -> ResourceDB_model -> get_resource_by_title($title);
		if ($resource_qry)
		{
			$row = $resource_qry -> row();
			$resource_id = $row -> id;
			// echo "The title \"<strong>$title</strong>\" is already in the repository. Please use another.";
			$edit_link = "<a href=\"resource/edit/" . $resource_id . "\">edit</a>";
			echo "This title is already in the repository. You can " . $edit_link . " the existing record" ;
		}
		else
		{
			//echo "The title \"<strong>$title</strong>\" is not in the database, and is ok to use.";
			echo "This title is not in the repository, and is ok to use";
		}
	}
	
	/* ---------- TAG FUNCTIONS ------------- */
	/**
	* Attach tags to a resource
	* If tags already in KEYWORD just attach by adding row to junction table, 
	* if tags not yet in KEYWORD then add them to that table then attach by
	* adding row to junction table. 
	* @param mixed $tags_ary Array of tag names to attach
	* @param int $resource_id ID of resource to attach tags to
	*/
	function attach_tags($tags_ary, $resource_id)
	{
		foreach ($tags_ary as $key => $val)
		{
			# Remove any white space from the tag, and if that leaves an
			# empty element (eg if user's typed ;;, or ;   ; or similar)
			# then remove it from the array 
			$val = trim($val);
			if (empty($val))
				{ unset($tags_ary[$key]); }
			# Now check if the tag already exists in the KEYWORD table, and if not add it
			$q = $this -> ResourceDB_model -> get_tag_id($val);  
			# If it's not there add it to the KEYWORD table and get the new ID
			if ($q -> num_rows() == 0)
			{
				# Get ID of inserted tag
				$tag_id = $this -> Edit_model -> add_tag($val);
			}
			# If tag's already in KEYWORD, just get its ID
			else
			{
				# Get ID of existing tag
				$tag_id = $q -> row() -> id;	
			}
			# Now put the tag ID in to the junction table with the resource ID
			# The model function checks if tag already attached
			$this -> Edit_model -> attach_tag($resource_id, $tag_id);
		}		
		
	}
	
	/**
	* Compare two sets of tags in arrays
	* Compare existing tag names attached to a resource, with those the
	* user's specified in the tags field, and return any tags in the 
	* old list that aren't in the new list
	* Could maybe use array_diff() but this is clearer IMO
	* NB: comparison is of strings, not IDs, because the user might type a tag
	* which doesn't yet exist. 
	* @param mixed $old_tags_ary Array of names of existing tags
	* @param mixed $new_tags_ary Array of names of user-specified tags
	* @return mixed Array of tagnames in old tags that are absent in new tags
	*/
	function compare_tags($old_tags_ary, $new_tags_ary)
	{
		$detached_tags = array();
		foreach ($old_tags_ary as $key => $val)
		{
			if (!(in_array($val, $new_tags_ary)))
			{
				$detached_tags[] = $val;
			}
		}
		return $detached_tags;
	}	
	
	/* --------- AUTOCOMPLETE FUNCTIONS ------------- >
	/**
	* Get titles from the RESOURCE table for use in auto-complete. 
	* Mostly same code as tag_autocomplete() so should combine funcs at 
	* some time in the future for aesthetic reasons, but wtf. 
	* No return value - the 'return' is an echo. 
	* @param boolean $json True if data to be returned as JSON, else false
	*/
	function resource_autocomplete($json=false)
	{
		$titles = $this -> ResourceDB_model -> get_public_resources();
		# Get what user's typed in, case-insensitive
		# The autocomplete plugin puts the search term in an element called 'q'	
        $q = strtolower($_POST["q"]);
		# If blank, quit
        if (!$q) return;
		
		# Go through all tags, shove them into an associative array with 
		# the key being the tag name and value the tag id
        foreach($titles->result() as $title)
        {
            $items[$title->title] = $title->id;
        }

		# Now search the array for the search term, and return matches as 
		# either key|value (eg 'hamster herding|20') or JSON
		foreach ($items as $key=>$value) 
		{
            if (strpos(strtolower($key), $q) !== false) 
			{
				if ($json) 
				{
					$match = Array ($key => $value);
					echo json_encode($match);
				}
				else
				{
					echo "$key|$value\n";
				}
					
	        }
        }		
		
	}
	
	/**
	* Get entries from the keyword table for use in auto-complete
	* @param boolean $json True if data to be returned as JSON, else false
	*/
	function tag_autocomplete($json=false)
	{
		# Call method in Edit model to return all entries from KEYWORD table
		$tags = $this -> Edit_model -> get_resource_tags();
		# Get what user's typed in, case-insensitive
		# The autocomplete plugin puts the search term in an element called 'q'	
        $q = strtolower($_POST["q"]);
		# If blank, quit
        if (!$q) return;
		
		# Go through all tags, shove them into an associative array with 
		# the key being the tag name and value the tag id
        foreach($tags->result() as $tag)
        {
            $items[$tag->name] = $tag->id;
        }

		# Now search the array for the search term, and return matches as 
		# either key|value (eg 'hamster herding|20') or JSON
		foreach ($items as $key=>$value) 
		{
            if (strpos(strtolower($key), $q) !== false) 
			{
				if ($json) 
				{
					$match = Array ($key => $value);
					echo json_encode($match);
				}
				else
				{
					echo "$key|$value\n";
				}
					
	        }
        }
	}
}
?>
