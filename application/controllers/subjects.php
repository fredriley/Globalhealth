<?php
/**
* Controller for subjects/categories
*/
class Subjects extends CI_Controller {

	# Constructor.
	function Subjects()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('RESOURCE');
		# Load URL and form helper classes	
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> helper('date');
		# Load form validation library
		$this->load->library('form_validation');
		$this->load->model('ResourceDB_model');
		$this->load->model('Edit_model');
		# Debugging
		//$this -> output -> enable_profiler(true);

	}

	
	public function index()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: subjects/categories";
		$data['heading'] = "Subjects/categories"; 	
		# run some DB queries for passing to the page content
		# get most popular tags - query sort descending by count of tag use
		$data['tags_query'] = $this -> ResourceDB_model -> get_tags_used('count desc');
		// for <meta> tags and DC
		$data['description'] = "Browse the Global Heath resource repository by tag and key word";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Tags"; 
		$data['active_submenu'] = ""; 
		$template['content'] = $this -> load -> view('admin/subjects_view', $data, TRUE);
		# Put the content into the second template
		$this -> load -> view('template2_view', $template);
		
	}
	
	/**
	* Insert a new record in the subject table
	* @return int | bool ID of subject if successful, else false
	*/
	function insert()
	{
		# If not a logged-in admin, shoo!
		if (! ($this->ion_auth->is_admin() ) )
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');
    	}	

		# Get key areas - new category must have a parent, and only one parent
		$data['key_areas_query'] = $this -> ResourceDB_model -> get_key_areas();
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: add category";
		$data['heading'] = "Add category"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Resource admin"; // active menu item
		$data['active_submenu'] = "Categories"; 
		
		$data['message'] = ""; 
		$data['error'] = "";
		
		# ==== FORM VALIDATION ======
		# Require the title field. Whilst key area is also required, that's a combo box which is 
		# bound to have a value. 
		$this->form_validation->set_rules('title', 'Category title', 'required|trim|xss_clean|is_unique[gh_subject.title]');
		
		# If the form doesn't validate, or indeed hasn't even been submitted, 
		# (re)populate with user data
		if ($this->form_validation->run() == FALSE)
		{
			$data ['error'] = validation_errors();	
			# Fill page template - template view called at function end
			$template['content'] = $this -> load -> view('admin/insert_subject_view', $data, TRUE);

		}
		# If form validates, insert record
		else
		{
			# Get form values for fields in subject table

			$record_data = array (
							'title' => $_POST['title'],
							'description' => $_POST['description'], 
							'key_area' => $_POST['key_area'], 
							);
			$result = $this -> Edit_model -> insert_subject($record_data);
			if (!$result)
			{
				$data['error'] = "Subject creation failed. Bummer. ";
				$template['content'] = $this -> load -> view('admin/insert_subject_view', $data, TRUE);
			}
			else
			{
				$data['subject_id'] = $result;
				$template['content'] = $this -> load -> view('admin/insert_subject_result_view', $data, TRUE);
			}
		}
		
		$this -> load -> view ('template2_view', $template);
		
		
	}
	
	/**
	* Edit a subject
	* @param int $id ID of subject in gh_subject table
	*/
	function edit($id = NULL)
	{

		# Only admins can edit subjects. Shoo the rest off. 
		if (! ($this->ion_auth->is_admin() ) ) 
		{
			redirect('home', 'refresh');
    	}
		
		$data['id'] = $id;
		$data['query'] = $this -> ResourceDB_model -> get_subject_record($id);
		$data['key_areas_query'] = $this -> ResourceDB_model -> get_key_areas();
		$data['message'] = "";
		$data['error'] = "";
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: edit category";
		$data['heading'] = "Edit category"; 	

		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Resource admin"; 
		$data['active_submenu'] = "Categories"; 
		
		# ==== FORM VALIDATION ======
		$this->form_validation->set_rules('title', 'Subject title', "required|trim|xss_clean");
		
		# If the form doesn't validate, or indeed hasn't even been submitted, 
		# (re)populate with user data
		if ($this->form_validation->run() == FALSE)
		{
			$data ['error'] = validation_errors();	
			# Load page data into template - the view will be called at function end
			$template['content'] = $this -> load -> view('admin/edit_subject_view', $data, TRUE);
		}	
		
		# If form validates, update record
		else
		{
	
			$record_data = array (
						'title' => $_POST['title'], 
						'description' => $_POST['description'], 
						'key_area' => $_POST['key_area'], 
						);
						
			# Run update query in model
			$this -> Edit_model -> update_subject($record_data, $id);
		
			# Set messages etc for the result page
			$data['title'] = "Edit subject: result";
			$data['heading']  = "Edit subject: result";
			$data['subject_title'] = $record_data['title'];
			$data['subject_id'] = $id; 
			$data['message'] = 'Subject edited ok'; 	
			# Load results page with data array
			$template['content'] = $this->load->view('admin/edit_subject_result_view', $data, TRUE);
		}
		

		# Put the content into the second template
		$this -> load -> view('template2_view', $template);
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this subject? You cannot undo this action, and some resources may be uncategorised as a result.\"";
		$this -> load -> view('confirm_script_view', $script_data);	
		# Don't load TinyMCE editor - let's keep the description simple and HTML-free		
	
	}
	
	function delete($id)
	{
	
		# If user's not an admin, see them off
		if (! ($this->ion_auth->is_admin() ) ) 
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');
    	}
		
		# Get subject title before deletion to show user in view
		$query = $this -> ResourceDB_model -> get_subject_record($id);
		if ($query->num_rows() == 0)
		{
			$data['message'] = "The subject ID ". $id . " doesn't exist in the database, so can't be deleted. 
				Tough mazoomas.";
		}
		else
		{
			$row = $query -> row();
			$data['resource_title'] = $row -> title;
			# Delete the resource record from the database
			 if (!$this -> Edit_model -> delete_subject($id))
			 {
				$data['message'] = "This subject could not be deleted. Bummer.";
			 }
			 else
			 {
				$data['message'] = "The subject \"" . $row -> title . "\" has been deleted for good. 
					It has gone to meet its maker. It's pushing up the daisies. Its child resources are now orphans. 
					It has joined the choir invisible. It is an ex-article. <em>Requiescat in pace</em>.";
			}
		}

	
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: delete subject";
		$data['heading'] = "Delete subject"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; // active menu item
		$data['active_leftnav'] = "Resource admin"; // active menu item
		$data['active_submenu'] = "Categories"; // active menu item
		$template['content'] = $this -> load -> view('admin/delete_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	
	}

}
?>
