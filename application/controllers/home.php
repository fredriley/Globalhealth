<?php
class Home extends CI_Controller  {

	# Constructor. Not needed in this case, included for show. 
	# Note that if you have a constructor you need to explicitly call its
	# parent to inherit its methods and properties, otherwise they'll be locally overridden
	function Home()
	{
		parent::__construct();
		$this -> load -> helper('url');

	}

	# Access to the basic welcome view via home/arse. The view has links to documentation, 
	# devt versions, CI docs, etc
	# Who's going to guess that? 
	function arse()
	{
		$data['title'] = "Global Health: home";
		$this->load->view('welcome_message', $data);
	}

	
	public function index()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: home";
		$data['heading'] = "Global Health Repository"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "Home"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = ""; // active menu item
		$template['content'] = $this -> load -> view('home_view', $data, TRUE);
		$this -> load -> view('template1_view', $template);

		
	}
	
}
?>
