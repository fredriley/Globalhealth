<?php
# Controller for test purposes only

class Test extends CI_Controller {

	function Test()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('RESOURCE');
		# Load URL and form helper classes	
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> helper('date');
		$this->load->model('ResourceDB_model');
		//$this->load->model('Test_model');
		# Turn on profiling for debugging
		//$this -> output -> enable_profiler(TRUE);


	}

	
	function index()
	{
		$data['title'] = "Ajax/JSON test";
		$this -> load -> view('test/test_view', $data);
	}
	
	/**
	* Process data from an Ajax call
	
	*/
	function ajax()
	{
		# get POST data, add a bit to show that it's coming from the controller
		$item = "From the controller 'ajax' " . trim ($this -> input -> post ('item'));
		# fill an array prior to JSON encoding
		$array = array ('result' => $item);
		# 'return' the Ajax data as JSON
		echo json_encode($array);
	}
	
	/** 
	* Test to display key areas and their child categories in a table
	*/
	function categories()
	{
		$this -> load -> model ('ResourceDB_model');

		# Get key areas (aka top level categories) and shove into an array
		# Query returns * in key_areas table (id, title, description)
		$data['query'] = $this -> ResourceDB_model -> get_key_areas();
		
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: categories test";
		$data['heading'] = "Categories test"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = ""; // active menu item
		$template['content'] = $this -> load -> view('test/categories_test_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);

	
		//$this -> load -> view('test/categories_test_view', $data);
	}
	/**
	* Test email library, particularly from Titan
	*/
	
	function email()
	{
		$data['from_email'] = 'fred.riley@gmail.com'; 
		$data['from_name'] = "Fred Riley"; 
		$data['to_email'] = "fred.riley@gmail.com";
		$data['subject'] = "Testing CI email class"; 
		$data['message'] = "Testing the CI email class. The sun has got his hat on, hip hip hip hooray...";
		$this->load->library('email');

		$this->email->from($data['from_email'], $data['from_name']);
		$this->email->to($data['to_email']); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 

		$this->email->subject($data['subject']);
		$this->email->message($data['message']);	

		$this->email->send();

		echo $this->email->print_debugger();
		$this -> load -> view('test/email_test_view', $data);
	}

	function email2()
	{
		$data['from_email'] = 'fred.riley@fredriley.org.uk'; 
		$data['from_name'] = "Fred Riley"; 
		$data['to_email'] = "fred.riley@gmail.com";
		$data['subject'] = "Testing CI email class"; 
		$data['message'] = "Testing the CI email class. The sun has got his hat on, hip hip hip hooray...";
		$this->load->library('email');

		$this->email->from($data['from_email'], $data['from_name']);
		$this->email->to($data['to_email']); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 

		$this->email->subject($data['subject']);
		$this->email->message($data['message']);	

		$this->email->send();

		echo $this->email->print_debugger();
		$this -> load -> view('test/email_test_view', $data);
	}

	
	/**
	* Get entries from the keyword table for use in auto-complete
	* @param boolean $json True if data to be returned as JSON, else false
	*/
	function tag_autocomplete($json=false)
	{
		# Call get_tags() method in Test model to return all entries from KEYWORD table
		$tags = $this -> Test_model -> get_resource_tags();
		# Get what user's typed in, case-insensitive
		# The autocomplete plugin puts the search term in an element called 'q'	
        $q = strtolower($_POST["q"]);
		# If blank, quit
        if (!$q) return;
		
		# Go through all tags, shove them into an associative array
        foreach($tags->result() as $tag)
        {
            $items[$tag->keyword_name] = $tag->keyword_num;
        }

		$items_found = array();		
		# Now search the array for the search term, and return matches as JSON
		//echo "[";
		foreach ($items as $key=>$value) 
		{
            if (strpos(strtolower($key), $q) !== false) 
			{
                //echo "{ name: \"$key\", to: \"$value\" }, ";
				# Shove into an array
				//$items_found[$key] = $value;
				//echo "{ name: \"$key\", to: \"$value\" }, ";
				if ($json) 
				{
					$match = Array ($key => $value);
					echo json_encode($match);
				}
				else
				{
					echo "$key|$value\n";
				}
					
	        }
        }
		//echo "]";
		
		# 'Return' the found items array as JSON for use in the autocomplete plugin
		//echo json_encode($items_found);
	}

}
?>
