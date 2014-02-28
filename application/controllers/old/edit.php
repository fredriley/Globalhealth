<?php
class Edit extends CI_Controller {

	# Constructor. 
	function Edit()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('RESOURCE');
		# Enable SQL 'debugging' with profiling
		//$this -> output -> enable_profiler(TRUE);
		# Load date helper classes	
		$this -> load -> helper('date');
		# Load Resource DB model with various get functions
		$this -> load -> model('ResourceDB_model');
		# Load Resource DB model with database edit functions
		$this -> load -> model('Edit_model');
		# Load form validation library
		$this->load->library('form_validation');

	}

	/**
	* Update existing resource record in RESOURCE table
	* and related tables (keyword) and junction tables. 
	* @param int $resource_id ID of resource to edit
	*/
	function index()
	{
		# Check that user has sufficient rights to edit, else redirect
		# Although the Edit item only appears in the menu for contributors and admins, 
		# user could reach it from URL editing
		# TO DO: either display unauthorised message on home page, or create new 'unauthorised' view
		# and load that. 
		echo $this -> uri -> segment(2);
		if (! ( ($this->ion_auth->is_admin()  || $this->ion_auth->in_group('contributor') || $this->ion_auth->in_group('HELM')) ) ) 
		{
    		# redirect them to the home page 
			# TO DO: redirect to a page with a message saying that they're not a contributor
			redirect('home', 'refresh');
    	}
		# If a resource has been chosen in the editchooseview view, the ID will
		# be passed in POST, so get it then re-call this controller, invoking 
		# the resource method with the ID
		if (isset($_POST['resource_id']))
		{
			$resource_id = $_POST['resource_id'];
			redirect("edit/resource/$resource_id", 'refresh');
		}
		# ...else if there's a resource_id in the URL, display the edit form
		# for that resource. If the segment doesn't exist FALSE is returned.
		elseif ($resource_id = $this -> uri -> segment(2))
		{
			redirect("edit/resource/$resource_id", 'refresh');
		}
		# If nowt in POST, just display the choose resource to edit view
		else
		{
			$data['title'] = "Choose resource to edit";
			$data['heading'] = "Choose resource to edit";
			# If ordinary contributor only display non-restricted visible records...
			if ( $this->ion_auth->in_group('contributor') )
			{
				$data['resource_query'] = $this -> ResourceDB_model -> get_public_resources();
			}
			# ...otherwise display the lot
			else
			{
				$data['resource_query'] = $this -> ResourceDB_model -> get_resources();
			}
			$this -> load -> view('resourcedb/editchooseview', $data);
		}
	}
	
	/**
	* Display and process edit form for a particular resource
	* @param into $resource_id ID of resource
	* @return boolean True if edit went ok, else false
	*/
	function resource($resource_id)
	{
		# Call model function to get resource record
		$q = $this -> ResourceDB_model -> get_resource_detail($resource_id);
		# Check that it exists (in case of URL editing in the browser)
		if ($q -> num_rows() == 0) 
		{ 
			$data['title'] = "No such resource"; $data['heading'] = "Resource not found"; 
			$data['error'] = "There is no resource with the ID $resource_id. Tough mazoomas.
								Please choose another resource to edit."; 
			$data['message'] = "";
			$this -> load -> view('resourcedb/database_error_view', $data);
		}
		else
		{
			$resource_title = $q -> row() -> title;
			$data['title'] = "Edit resource " . $resource_title;
			$data['heading'] = "Edit resource " . $resource_title;
			$data['resource__id'] = $resource_id; 
			
			# Get the user ID to save as record editor
			$user_id = $this->ion_auth->user()->row()-> id;
			# Set messages for the view file
			$data['title'] = 'Global health repository: edit resource';
			$data['heading'] = 'Edit resource';
			# Set user message and error as blanks, to prevent PHP warning if one or t'other isn't set
			$data['message'] = ""; $data['error'] = "";
			
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
			
			# -- ORIGINS --
			$data['origins_query'] = $this -> ResourceDB_model -> get_origins();

			# -- RESOURCE TYPES ---
			$data['resource_types_query'] = $this -> ResourceDB_model -> get_resource_types();
			
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
			# validation rules, hence a rul for all elements below. See CI Forum thread at:
			# http://codeigniter.com/forums/viewthread/170221/

			# NB: The callback function to check the title has the existing title as a 'parameter' in 
			# sqare brackets, as just checking for the title existing would always 
			# return true - we need to check that the edited title exists or not. 
			$this->form_validation->set_rules('title', 'Title', "required|trim|xss_clean|callback_title_check[$resource_title]");
			$this->form_validation->set_rules('url', 'URL', 'required|trim|xss_clean|prep_url');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
			$this->form_validation->set_rules('tags', 'Tags', 'trim|xss_clean');
			$this->form_validation->set_rules('creator', 'Creator', 'trim|xss_clean');
			$this->form_validation->set_rules('rights', 'Rights', 'trim|xss_clean');		
			$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean');		
			
			# If the form doesn't validate, or indeed hasn't even been submitted, 
			# (re)populate with user data
			if ($this->form_validation->run() == FALSE)
			{
				$data ['error'] = validation_errors();	
				$this -> load -> view('resourcedb/editview', $data);

			}
			# If form validates, update record
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
								'creator' => $_POST['creator'], 
								'source' => $_POST['source'],  
								'rights' => $_POST['rights'], 
								'restricted' => $_POST['restricted'], 
								'visible' => $_POST['visible'], 
								'metadata_created' => $now, 
								'metadata_modified' => $now, 
								'metadata_author' =>  $user_id, 
								'notes' => $_POST['notes']			
								);
								
				
				# Run update query in model
				$this -> Edit_model -> update_resource($record_data, $resource_id);	
				
				
				# ======== JUNCTION TABLES ==========
				# Now get form values for fields using junction tables				
	
				# TAGS
				# First, get tag(s) user's inserted. Get cleaned field text...
				$tags = $this -> security -> xss_clean($_POST['tags']);
				# ...then split string by the semicolon delimiter...
				$tags_ary = explode(';', $tags);
				# ...then remove any duplicate tags...			
				$tags_ary = array_unique($tags_ary);
				# ...then see if the user's removed any existing tags.
				$detached_tags_ary = $this -> compare_tags($old_tags_ary, $tags_ary);
				# Detach the tags removed from reource 
				# (deleting rows in the RESOURCE_KEYWORD junction table)
				foreach($detached_tags_ary as $key => $val)
				{
					# Get id of tag to detach
					$q = $this -> ResourceDB_model -> get_tag_id($val);
					$tag_id = $q -> row() -> keyword_num;
					$this -> Edit_model -> detach_tag($resource_id, $tag_id);
				}
				# Go through user-entered tags and attach to the resource, 
				# adding new tags to KEYWORDS if not already exist
				$this -> attach_tags($tags_ary, $resource_id);
				
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
				$this->load->view('resourcedb/edit_result_view', $data);
			} // end if validates
		} // end else 
		
	}
	
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
	* Compare two sets of subjects in arrays
	* Compare existing subjects attached to a resource, with those the
	* user's selected in the subjects list, and return any subjects in the 
	* old list that aren't in the new list
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
	
	/**
	* Callback function for validation rule, to check resource title is unique
	* This is a wrinkle on the function of the same name in the insert controller, because
	* as this is an edit form then simply checking for a title the same in the DB will always
	* hit the current title, so we need to check the existing title and the title the user's edited.
	* A callback function can't take two params, so instead the existing and proposed title are 
	* passed in the multi-valued $params which is then exploded. See CI forum post at:
	* http://codeigniter.com/forums/viewthread/166015/
	*
	* @param string $new_title Resource title entered by user
	* @param string $old_title Existing resource title
	* @return boolean If true proposed title is unique, else title already exists
	*/
	function title_check($new_title, $old_title)
	{
		# Only check if the user's edited the title...
		if ($new_title != $old_title)
		{
			# Run model query to see if there's an exact match with the proposed title
			$query = $this -> Edit_model -> title_search($new_title);
			# If the query returns no rows then fine, else the title already exists
			if ($query -> num_rows() == 0)
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message ('title_check', "This title already exists in the database - please try another.");
				return FALSE;
			}
		}
		# ...else if user's not edited the title just return true to allow validation to succeed
		else
		{ return TRUE; }
	}
	

	
}
?>
