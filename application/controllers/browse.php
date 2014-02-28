<?php
class Browse extends CI_Controller {

	# Constructor. 
	function Browse()
	{
		parent::__construct();

		# Load URL and form helper classes	
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> helper('date');
		$this->load->model('ResourceDB_model');
		# Debugging
		//$this -> output -> enable_profiler(true);

	}

	
	public function index()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: browse resources";
		$data['heading'] = "Browse resources"; 	
		# run some DB queries for passing to the page content
		$data['subjects_query'] = $this -> ResourceDB_model -> get_subjects();
		# get 25 most popular tags - query sort descending by count of tag use
		# Query returns tagname,  tag id, and count of tagged resources
		$data['tags_query'] = $this -> ResourceDB_model -> get_tags_used('count desc', 25);
		# get resource types - by default, types that are used by existing resources. 
		# To get all types, supply 'false' param
		$data['types_query'] = $this -> ResourceDB_model -> get_resource_types();
		// for <meta> tags and DC
		$data['description'] = "Browse the Global Heath resource repository by tag, subject and resource type";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = ""; // active menu item
		$data['active_leftnav'] = "Browse"; // active menu item
		$data['active_submenu'] = "Browse"; // active menu item
		$data['query'] = $this -> ResourceDB_model -> get_public_resources();	
		$template['content'] = $this -> load -> view('search/browse_view', $data, TRUE);
		# Put the content into the second template
		$this -> load -> view('template2_view', $template);
		
	}
	
		/**
	* List resource titles by tag or subject.
	* Also get the subject or tag name for display in a 'browse results' page
	* @param string $type Values: 'tag', 'subject', 'type', 'editor'
	* @param int $id Primary key from KEYWORD or SUBJECT
	*/
	function list_titles($type, $id)
	{
		if ($type == "tag")
		{
			# Run query to get titles for this tag
			# Model function declaration:
			# function get_titles_by_browse($browsetype='tag', $id, $order='title')
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('tag', $id, 'title');
			# Get the tag title for display to the user
			$qry = $this -> ResourceDB_model -> get_tag_record($id);
			$title = $qry -> row() -> name;
		}
		if ($type == "subject")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('subject', $id, 'title');
			$qry = $this -> ResourceDB_model -> get_subject_record($id);
			$title = $qry -> row() -> title;
		}
		
		if ($type == "type")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('type', $id, 'title');
			$qry = $this -> ResourceDB_model -> get_type_record($id);
			$title = $qry -> row() -> title;
				
		}
		if ($type == "editor")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('editor', $id, 'title');
			# Get the metadata author (record editor) name from the ion-auth library
			//$qry = $this -> ResourceDB_model -> get_type_record($id);
			$user = $this->ion_auth->user($id)->row();
			$title = $user -> first_name . " " . $user -> last_name;
		}
		
		
		// define some vars to pass to the nav and page views
		$data['title'] = 'Browse by ' . $type . " \"" . $title . "\"";
		$data['heading'] = 'Browse by ' . $type . " \"" . $title . "\"";
		// for <meta> tags and DC
		$data['description'] = "Browse resources by $type in the Global Health repository, a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease, latest, urbanisation";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Browse"; // active menu item
		$data['active_submenu'] = "";
		$template['content'] = $this -> load -> view('search/list_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);	
		# Load some JS at the page end to toggle record views
		$this -> load -> view('resource/list_toggle_script_view');

	}

}
?>
