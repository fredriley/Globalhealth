<?php
class Search extends CI_Controller {

	# Constructor. Not needed in this case, included for show. 
	# Note that if you have a constructor you need to explicitly call its
	# parent to inherit its methods and properties, otherwise they'll be locally overridden
	function Search()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('RESOURCE');
		# Load URL and form helper classes	
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> helper('date');
		$this->load->model('ResourceDB_model');

	}

	/**
	* Main resource search form
	* Uses autocomplete on the search fields. On search, the form reloads 
	* with search results
	*/
	function index()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: search";
		$data['heading'] = "Search the repository"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Search"; // active menu item
		$data['active_submenu'] = "Search"; 
		
		# SEARCH
		# If search pressed then do search and pass resulting query to search_view
		# See if there's owt in POST, then if it's a title or URL search
		# The TRUE param turns on runs POST data through the XSS filter
		if ($this -> input -> post())
		{
			# Title search field on page and in navbar - both call this controller
			if ( ( $search_term = $this -> input -> post('title', TRUE) ) ||
					($search_term = $this -> input -> post('navbar_search', TRUE)) )
				{ 
					$data['query'] = $this -> ResourceDB_model -> search_title($search_term);
				}
				
			# URL search field on search form
			if ( $search_term = $this -> input -> post('url', TRUE))
				{ 
					$data['query'] = $this -> ResourceDB_model -> search_url($search_term);
				}
			# Tag search field on search form
			if ( $search_term = $this -> input -> post('tag', TRUE))
				{ 
					$data['query'] = $this -> ResourceDB_model -> search_resources_by_tag_substring($search_term);
				}
			$data['message'] = "Searching for <strong>" . $search_term . "</strong>";
			//$data['query'] = $this -> ResourceDB_model -> search_title($search_term);
			# USE PAGINATION FOR RESULTS??

		}
		$template['content'] = $this -> load -> view('search/search_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
		# Load autocomplete Javascript to end of page
		$this -> load -> view('search/search_autocomplete_view');

	}
	
	/**
	* Get last N records added
	* 
	* @param int n Number of records to show
	*/
	function latest($n=10)
	{
		$this -> load -> model('ResourceDB_model');
		# Get 
		$data['latest_query'] = $this -> ResourceDB_model -> get_public_resources($n, 'metadata_created desc');
		$data['n'] = $n;
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: latest resources";
		$data['heading'] = "Latest resources"; 		
		// for <meta> tags and DC
		$data['description'] = "Latest $n resources added to the Global Health repository, a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease, latest, urbanisation";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Latest resources"; // active menu item
		$data['active_submenu'] = "Latest";
		$template['content'] = $this -> load -> view('resource/latest_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);		
	}
	
}
?>
