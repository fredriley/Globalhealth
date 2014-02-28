<?php
/**
* Controller for key areas (top-level categories)
*/
class Keyareas extends CI_Controller {

	# Constructor.
	function Keyareas()
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
	
	function edit($id)
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: edit key area";
		$data['heading'] = "Edit key area"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; // active menu item
		$data['active_leftnav'] = "Resource admin"; // active menu item
		$data['active_submenu'] = "Key areas"; // active menu item
		$data['error'] = "";
		$data['message'] = "";
		
		$data['query'] = $this -> ResourceDB_model -> get_key_area_record($id);
		# ==== FORM VALIDATION ======
		$this->form_validation->set_rules('title', 'Key area title', "required|trim|xss_clean");
		
		# If the form doesn't validate, or indeed hasn't even been submitted, 
		# (re)populate with user data
		if ($this->form_validation->run() == FALSE)
		{
			$data ['error'] = validation_errors();	
			# Load page data into template - the view will be called at function end
			$template['content'] = $this -> load -> view('admin/edit_keyarea_view', $data, TRUE);
		}	

		# If form validates, update record
		else
		{
	
			$record_data = array (
						'title' => $_POST['title'], 
						'description' => $_POST['description'],
						);
						
			# Run update query in model
			$this -> Edit_model -> update_key_area($record_data, $id);
		
			# Set messages etc for the result page
			$data['title'] = "Edit key area: result";
			$data['heading']  = "Edit key area: result";
			$data['keyarea_title'] = $record_data['title'];
			$data['keyarea_id'] = $id; 
			$data['message'] = 'Key area edited ok'; 	
			# Load results page with data array
			$template['content'] = $this->load->view('admin/edit_keyarea_result_view', $data, TRUE);
		}		
	
		$this -> load -> view('template2_view', $template);
	
	}
	
}
?>