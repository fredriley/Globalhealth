<?php
class Insert extends CI_Controller {

	# Constructor. 
	function Insert()
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
		$this->load->helper('security');

	}

	/**
	* Insert new resource into database
	* Inserts new record into RESOURCE table, and related tables (keyword) and 
	* junction tables. 
	*/
	function index()
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
		$user_id = $this->ion_auth->user()->row()-> id;
		$data['title'] = 'Global Health repository: insert resource';
		$data['heading'] = 'Insert resource';
		# Set user message and error as blanks, to prevent PHP warning if one or t'other isn't set
		$data['message'] = ""; $data['error'] = "";
		
		# Populate form elements. 
		# Call function in ResourceDB_model to get subject areas
		# False param indicates that all subjects should be returned, not just those 'in use'
		# by existing resources
		$data['subjects_query'] = $this -> ResourceDB_model -> get_subjects(false);
		$data['origins_query'] = $this -> ResourceDB_model -> get_origins();
		# Note parameter in function call - this will return all types, not just those 'in use', 
		# which is important for an input form.
		$data['resource_types_query'] = $this -> ResourceDB_model -> get_resource_types(FALSE);
		
		# ==== FORM VALIDATION ======
		# Note that set_value() to repopulate the form *only* works on elements with 
		# validation rules, hence a rul for all elements below. See CI Forum thread at:
		# http://codeigniter.com/forums/viewthread/170221/
		# Custom rule to check on unique resource title
		# NB: callback func param has to start with 'callback_'
		$this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean|callback_title_check');
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
			$this -> load -> view ('resourcedb/insertview.php', $data);
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
							'creator' => $_POST['creator'], 
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
				$this -> load -> view ('resourcedb/database_error_view', $data);
				//exit; 
			}	
			# ...but if it worked set flag to true and store new resource id
			else 
			{ 
				$resource_id = $result;
			}				
			
			# ======== JUNCTION TABLES ==========
			# Now get form values for fields using junction tables				

			# TAGS
			# First, get tag(s) user's inserted. Get cleaned field text...
			$tags = $this -> security -> xss_clean($_POST['tags']);
			# ...then split string by the semicolon delimiter...
			$tags_ary = explode(';', $tags);
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
					$tag_id = $q -> row() -> keyword_id;	
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
			$this->load->view('resourcedb/insert_result_view', $data);
		} // end if validates
		


	}
	
	/**
	* Callback function for validation rule, to check resource title is unique
	* @param string $title Resource title entered by user
	* @return boolean If true title is unique, else title already exists
	*/
	function title_check($title)
	{
		# Run model query to see if there's an exact match with the proposed title
		$query = $this -> Edit_model -> title_search($title);
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
	
	/**
	* Removes array elements that are either empty or have just a single space character
	* @param array $ary Array to be modified, passed by reference.
	* No return value due to the passing by reference so original array is modified directly
	*/
	function remove_empty_elements(&$ary)
	{
		foreach ($ary as $key => $val)
		{
			if ( ($val == " ") || empty($val) )
			{
				# Remove array key
				unset($ary[$key]);
			}
		}
	}
	
}
?>
