<?php
class Login_success extends CI_Controller {

	# Constructor. Not needed in this case, included for show. 
	# Note that if you have a constructor you need to explicitly call its
	# parent to inherit its methods and properties, otherwise they'll be locally overridden
	function About()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('RESOURCE');
		# Load URL and form helper classes	
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> helper('date');

	}

	
	# Post-login page
	function index()
	{

		# Call function in ion-auth library to get current user details
		$data['user'] = $this->ion_auth->user()->row();
		# Get group(s) user's in - this passes to view as a mysql_result object
		$data['users_groups'] = $this->ion_auth->get_users_groups();
		// define some vars to pass to the nav and page views
		$data['title'] = "Login successful";
		$data['heading'] = "Login successful"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "";
		$data['active_submenu'] = ""; 
		# Get the login success page view and shove it into a variable...
		$template['content'] = $this -> load -> view('auth/login_success_view', $data, TRUE);
		# ...to then be passed to a template view for display
		$this -> load -> view('template2_view', $template);

	}
	
}
?>
