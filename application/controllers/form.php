<?php

/**
* Global Health project forms controller.
*
* Contains various custom functions relating to form display, response and input.
* @author Fred Riley <fred.riley@gmail.ac.uk>
* @version 1.0
* @package Global Health
*/

class Form extends CI_Controller {
	
	function Form()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model('ResourceDB_model');
		# Turn on profiling for debugging
		//$this -> output -> enable_profiler(TRUE);
	}
	
	public function index()
	{
		$data['title'] = "Global Health forms";
		$data['heading'] = "Forms on the Global Health site"; 		
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = ""; 
		$data['active_submenu'] = ""; 
		$template['content'] = $this -> load -> view('forms/form_view', $data, TRUE);
		$this -> load -> view('template2_view', $template);		
	
	}
	
	# User contact form
	public function contact()
	{
		$data['title'] = "Global Health: contact";
		$data['heading'] = "Contact the Global Health project"; 		
		$data['description'] = "Contact details for the Global Health project";
		$data['keywords'] = "";
		$data['active_topnav'] = "Contact"; 
		$data['active_leftnav'] = ""; 
		$data['active_submenu'] = ""; 
		$template['content'] = $this -> load -> view('forms/contact_view', $data, TRUE);
		$this -> load -> view('template2_view', $template);
		# add extra form validation JS after footer
		$this -> load -> view('forms/validation_script_view');
	}
	
	# User registration request form
	public function request()
	{
		$data['title'] = "Global Health: registration request";
		$data['heading'] = "User registration request"; 		
		$data['description'] = "Request form to request registration with the Global Health project.";
		$data['keywords'] = "";
		$data['active_topnav'] = "Contact"; 
		$data['active_leftnav'] = "Request registration"; 
		$data['active_submenu'] = ""; 
		$template['content'] = $this -> load -> view('forms/request_view', $data, TRUE);
		$this -> load -> view('template2_view', $template);
		# add extra form validation JS after footer
		$this -> load -> view('forms/validation_script_view');
	}
	
	
	public function thanks()
	{
		$data['title'] = "Global Health: thanks";
		$data['heading'] = "Thanks!"; 		
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = "Contact"; 
		$data['active_leftnav'] = ""; 
		$data['active_submenu'] = ""; 
		$template['content'] = $this -> load -> view('forms/thanks_view', $data, TRUE);
		$this -> load -> view('template2_view', $template);	
	}
	
	public function error()
	{
		$data['title'] = "Global Health contact: error";
		$data['heading'] = "Error!"; 		
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = ""; 
		$data['active_submenu'] = ""; 
		$template['content'] = $this -> load -> view('forms/error_view', $data, TRUE);
		$this -> load -> view('template2_view', $template);	
	
	}	
	

}
?>
