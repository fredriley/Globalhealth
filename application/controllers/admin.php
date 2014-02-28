<?php
/**
* Resource administration controller. 
* Administer resource records and metadata
* @author Fred Riley <fred.riley@gmail.com>
* @version 1.0
* @package Global Health
*/
class Admin extends CI_Controller 
{

	# Constructor
	function Admin()
	{
		parent::__construct();
		$this -> load -> model("ResourceDB_model");
		# Load pagination library for recordset paging
		$this -> load -> library("pagination");
		# Debugging
		//$this -> output -> enable_profiler(true);
	}

	function index()
	{
		# If the logged-in user isn't an admin, see them off
		if (! ($this->ion_auth->is_admin()  ) )
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');		
		}
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: administer resource";
		$data['heading'] = "Administer resources"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Resource admin"; // active menu item
		$data['active_submenu'] = "Home"; 
		$template['content'] = $this -> load -> view('admin/admin_view', $data, TRUE);
		$this -> load -> view ('template2_view', $template);
	}
	
	/* -------------- CATEGORIES ----------- */
	/**
	* Manage categories in the repository. 
	* Handles a simple taxonomy of top and second-level categories. 
	*/
	function categories()
	{
		# If the logged-in user isn't an admin, see them off
		if (! ($this->ion_auth->is_admin()  ) )
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');		
		}	
		
		# Get key areas (aka top level categories) and shove into an array
		# Query returns * in key_areas table (id, title, description)
		$data['keyarea_query'] = $this -> ResourceDB_model -> get_key_areas();
		# Get all subjects, and the resources they categorise
		$data['subjects_query'] = $this -> ResourceDB_model -> get_subjects(false);

		# Get resources
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: administer categories";
		$data['heading'] = "Categories"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; // active menu item
		$data['active_leftnav'] = "Resource admin"; // active menu item
		$data['active_submenu'] = "Categories"; // active menu item
		$template['content'] = $this -> load -> view('admin/category_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);	
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this subject? You cannot undo this action, and some resources may become uncategorised.\"";
		$this -> load -> view('confirm_script_view', $script_data);
	
	
	}
	
	/* -------------- KEY AREAS ------------ */
	function keyareas()
	{
		# If the logged-in user isn't an admin, see them off
		if (! ($this->ion_auth->is_admin()  ) )
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');		
		}	
		
		$data['query'] = $this -> ResourceDB_model -> get_key_areas();
		
		# Set values for view template
		$data['title'] = "Global Health: administer key areas";
		$data['heading'] = "Key areas"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Resource admin"; // active menu item
		$data['active_submenu'] = "Key areas"; 
		$template['content'] = $this -> load -> view('admin/key_areas_view', $data, TRUE);
		$this -> load -> view ('template2_view', $template);	
	}
	
	/* -------------- RESOURCES ------------ */
	/**
	
	* Manage repository resources
	*/
	function resources()
	{
		# If the logged-in user isn't an admin, see them off
		if (! ($this->ion_auth->is_admin()  ) )
		{
    		# redirect them to the home page 
			redirect('home', 'refresh');		
		}
		
		# SEARCH
		# If search pressed then do search and pass resulting query to search_view
		# See if there's owt in POST, else skip
		# The TRUE param turns on runs POST data through the XSS filter
		if ($this -> input -> post())
		{
			# Title substring
			if ($this -> input -> post('search_title', TRUE))
				{ $substr_title = $_POST['search_title']; }
			elseif ($this -> input -> post('navbar_search', TRUE))
				{ $substr_title = $_POST['navbar_search']; }

			$data['message'] = "Searching for <strong>" . $substr_title . "</strong>";
			$data['query'] = $this -> ResourceDB_model -> search_title($substr_title);

		}
		
		# PAGINATION
		# Setup and run result pagination
		# First, create array of config items to pass to pagination class
		$config = array();
        $config["base_url"] = base_url() . "admin/resources/";
        $config["total_rows"] = $this -> ResourceDB_model -> table_count('gh_resource');
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
		$this->pagination->initialize($config); 

		# The recordset offset  is set in the third URI segment, eg:
		# admin/resources/5 
		# Ternary operator: if segment 3 is set then assign it to $page, 
		# else assign 0 to $page (ie first page in recordset)
		$page = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
		# Get all resources, public and restricted, setting limit, offset
		$query = $this -> ResourceDB_model -> get_resources($config["per_page"], $page);
		# Put the query results into an assoc array
        if ($query -> num_rows() > 0) 
		{
            foreach ($query -> result() as $row) 
			{
                $resources[] = $row;
            }
        }
		
		# Display a message "showing records x to y of n"
		$offset = ($this -> uri -> segment(3)) + 1; // starting record
		$per_page = $config['per_page']; 
		$total = $config['total_rows']; 
		$to = ($offset + $per_page) - 1; // ending record
		# If we're on the last page then set the ending record number to the total records
		if ($to > $total)
		{ $to = $total; }
		$data['page_info'] = "Showing records " . $offset . " to " . $to . " of " . $total . " alphabetically by title<br>";
		$data['results'] = $resources;
		$data["links"] = $this -> pagination -> create_links();
		
		# Set values for view template
		$data['title'] = "Global Health: administer resources";
		$data['heading'] = "Administer resources"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Resource admin"; // active menu item
		$data['active_submenu'] = "Resources"; 
		$template['content'] = $this -> load -> view('admin/resources_view', $data, TRUE);
		$this -> load -> view ('template2_view', $template);
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this resource? You cannot undo this action.\"";
		$this -> load -> view('confirm_script_view', $script_data);
		# Load autocomplete Javascript to end of page
		$this -> load -> view('search/search_autocomplete_view');
	
	
	}
	
	
	/* ------------------ TAGS --------------------- */
	/**
	* Manage tags in the database
	*
	**/
	function tags()
	{
	
		# PAGINATION
		# Setup and run result pagination
		# First, create array of config items to pass to pagination class
		$config = array();
        $config["base_url"] = base_url() . "admin/tags/";
        $config["total_rows"] = $this -> ResourceDB_model -> table_count('gh_keyword');
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
		$this->pagination->initialize($config); 
		
		# Create the message "showing records x to y of n"
		$offset = ($this -> uri -> segment(3)) + 1; // starting record
		$per_page = $config['per_page']; 
		$total = $config['total_rows']; 
		$to = ($offset + $per_page) - 1; // ending record
		
		# The recordset offset  is set in the third URI segment, eg:
		# admin/resources/5 
		# Ternary operator: if segment 3 is set then assign it to $page, 
		# else assign 0 to $page (ie first page in recordset)
		$page = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
		# If we're on the last page then set the ending record number to the total records
		if ($to > $total)
		{ $to = $total; }
		$data['page_info'] = "Showing tags " . $offset . " to " . $to . " of " . $total . " alphabetically by title<br>";
		
		# Get all tags, setting order_by, limit, offset. The model function returns a query object 
		# with the fieldnames tagname, id, count (number of times tag used)
		$query = $this -> ResourceDB_model -> get_tags_all($config["per_page"], $page);
		# Put the query results into an assoc array
		$tags = Array();
        if ($query -> num_rows() > 0) 
		{
            foreach ($query -> result() as $row) 
			{
                $tags[] = $row;
            }
        }
		$data['tags'] = $tags;
		$data["links"] = $this -> pagination -> create_links();
		
		# TEMPLATE VIEW
		# Set values for view template
		$data['title'] = "Global Health: administer tags";
		$data['heading'] = "Administer tags"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Resource admin"; // active menu item
		$data['active_submenu'] = "Tags"; 
		$template['content'] = $this -> load -> view('admin/tags_view', $data, TRUE);
		$this -> load -> view ('template2_view', $template);	
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this tag? You cannot undo this action.\"";
		$this -> load -> view('confirm_script_view', $script_data);
	
	
	}
	
}