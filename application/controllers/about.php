<?php
class About extends CI_Controller  {

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
		$this->load->model('ResourceDB_model');
		# Turn on profiling for debugging
		//$this->output->enable_profiler(TRUE);

	}

	public function index()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: about";
		$data['heading'] = "About the Global Health project"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "About"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "About"; // active menu item
		$data['query'] = $this -> ResourceDB_model -> get_public_resources();	
		$template['content'] = $this -> load -> view('about/about_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
		
	}
	
	
	public function globalisation()
	{
		# Get record in key area table. This key area is id 1
		$query = $this -> ResourceDB_model -> get_key_area_record(1);
		$key_area = $query -> row();
		# Array of topics to be displayed as bullet points in view
		# Get child categories of the key area 
		$children_qry = $this -> ResourceDB_model -> get_key_area_children(1);
		# Put titles into an array and pass to the view in the $data array
		foreach ($children_qry -> result() as $child)
		{
			$children[] = $child -> title;
		}
		$data['topics'] = $children;

		# The call below returns the latest 10 resources added to the subject's category
		$data['query'] = $this -> ResourceDB_model -> get_key_area_resources($key_area -> id, 0, 10, "metadata_created desc");	
		
		// define some vars to pass to the nav and page views
		$data['title'] = $key_area -> title;
		$data['heading'] = $key_area -> title;		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "About"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "Globalisation"; // active menu item

		$template['content'] = $this -> load -> view('about/about_category_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	}

	
	public function globalhealth()
	{
	
		# Get record in key area table. This key area is id 2
		$query = $this -> ResourceDB_model -> get_key_area_record(2);
		$key_area = $query -> row();
		// define some vars to pass to the nav and page views
		$data['title'] = $key_area -> title;
		$data['heading'] = $key_area -> title;			
		# Array of topics to be displayed as bullet points in view
		# Get child categories of the key area 
		$children_qry = $this -> ResourceDB_model -> get_key_area_children(2);
		# Put titles into an array and pass to the view in the $data array
		foreach ($children_qry -> result() as $child)
		{
			$children[] = $child -> title;
		}
		$data['topics'] = $children;
		# The call below returns the latest 10 resources added to the subject's category
		$data['query'] = $this -> ResourceDB_model -> get_key_area_resources($key_area -> id, 0, 10, "metadata_created desc");	

		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "About"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "Global health"; // active menu item

		$template['content'] = $this -> load -> view('about/about_category_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	}

	public function professions()
	{
		# Get record in key area table. This key area is id 3
		$query = $this -> ResourceDB_model -> get_key_area_record(3);
		$key_area = $query -> row();
		// define some vars to pass to the nav and page views
		$data['title'] = $key_area -> title;
		$data['heading'] = $key_area -> title;			
		# Array of topics to be displayed as bullet points in view
		# Get child categories of the key area 
		$children_qry = $this -> ResourceDB_model -> get_key_area_children(3);
		# Put titles into an array and pass to the view in the $data array
		foreach ($children_qry -> result() as $child)
		{
			$children[] = $child -> title;
		}
		$data['topics'] = $children;
		# The call below returns the latest 10 resources added to the subject's category
		$data['query'] = $this -> ResourceDB_model -> get_key_area_resources($key_area -> id, 0, 10, "metadata_created desc");	
		
		// define some vars to pass to the nav and page views
		$data['title'] = "Health professions in a global context";
		$data['heading'] = "Health professions in a global context"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "About"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "Professions"; // active menu item
	
		$template['content'] = $this -> load -> view('about/about_category_view', $data, TRUE);

		$this -> load -> view('template2_view', $template);
	
	}
	
	
	public function teaching()
	{
		# Get record in key area table. This key area is id 5
		$query = $this -> ResourceDB_model -> get_key_area_record(5);
		$key_area = $query -> row();
		// define some vars to pass to the nav and page views
		$data['title'] = $key_area -> title;
		$data['heading'] = $key_area -> title;			
		# Array of topics to be displayed as bullet points in view
		# Get child categories of the key area 
		$children_qry = $this -> ResourceDB_model -> get_key_area_children(5);
		# Put titles into an array and pass to the view in the $data array
		foreach ($children_qry -> result() as $child)
		{
			$children[] = $child -> title;
		}
		$data['topics'] = $children;
		# The call below returns the latest 10 resources added to the subject's category
		$data['query'] = $this -> ResourceDB_model -> get_key_area_resources($key_area -> id, 0, 10, "metadata_created desc");	
		
		// define some vars to pass to the nav and page views
		$data['title'] = "Teaching global health";
		$data['heading'] = "Teaching global health"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "About"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "Teaching"; // active menu item
		$template['content'] = $this -> load -> view('about/about_category_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	}	

	public function electives()
	{
	
		# Get record in key area table. This key area is id 4
		$query = $this -> ResourceDB_model -> get_key_area_record(4);
		$key_area = $query -> row();
		// define some vars to pass to the nav and page views
		$data['title'] = $key_area -> title;
		$data['heading'] = $key_area -> title;			
		# Array of topics to be displayed as bullet points in view
		# Get child categories of the key area 
		$children_qry = $this -> ResourceDB_model -> get_key_area_children(4);
		# Put titles into an array and pass to the view in the $data array
		foreach ($children_qry -> result() as $child)
		{
			$children[] = $child -> title;
		}
		$data['topics'] = $children;
		# The call below returns the latest 10 resources added to the subject's category
		$data['query'] = $this -> ResourceDB_model -> get_key_area_resources($key_area -> id, 0, 10, "metadata_created desc");	
		
		// define some vars to pass to the nav and page views
		$data['title'] = "Overseas electives";
		$data['heading'] = "Overseas electives"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "About"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "Electives"; // active menu item

		$template['content'] = $this -> load -> view('about/about_category_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	}
	


	public function technotes()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: technical notes";
		$data['heading'] = "Technical notes on the repository"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "About"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "Technical"; // active menu item
		$data['query'] = $this -> ResourceDB_model -> get_public_resources();	
		$template['content'] = $this -> load -> view('about/technotes_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	}
	
}
?>
