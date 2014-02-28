<?php
/**
* Controller for tag cloud and search
*/
class Tags extends CI_Controller {

	# Constructor.
	function Tags()
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

	}

	
	public function index()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: tags and keywords";
		$data['heading'] = "Tags and keywords"; 	
		# run some DB queries for passing to the page content
		# get most popular tags - query sort descending by count of tag use
		$data['tags_query'] = $this -> ResourceDB_model -> get_tags_used('count desc');
		// for <meta> tags and DC
		$data['description'] = "Browse the Global Heath resource repository by tag and key word";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Tags"; 
		$data['active_submenu'] = "Tags"; 
		$template['content'] = $this -> load -> view('search/tags_view', $data, TRUE);
		# Put the content into the second template
		$this -> load -> view('template2_view', $template);
		
	}
	
	/**
	* Delete a tag then reload the tags admin page
	* @param int $tag_id ID of tag to delete
	*/ 
	function delete($tag_id)
	{
		if ($this -> Edit_model -> delete_tag($tag_id))
		{
			$message = "Tag deleted ok";
		}
		else
		{
			$message = "Couldn't delete the tag. Bummer. ";
		}
		
		# Set flashdata message to display on tags admin page
		$this->session->set_flashdata('message', $message);
		# redirect them to the tags admin page 
		redirect('admin/tags', 'refresh');
	
	}
	
	/**
	* Edit a tag
	*/
	function edit($tag_id = NULL)
	{

		# Check that user has sufficient rights to edit, else redirect
		# Although the Edit item only appears in the menu for contributors and admins, 
		# user could reach it from URL editing
		if (! ( ($this->ion_auth->is_admin()  || $this->ion_auth->in_group('contributor') ) ) ) 
		{
    		# redirect them to the home page 
			# TO DO: redirect to a page with a message saying that they're not a contributor
			redirect('home', 'refresh');
    	}
		
		$data['id'] = $tag_id;
		$data['query'] = $this -> ResourceDB_model -> get_tag_record($tag_id);
		$data['message'] = "";
		$data['error'] = "";
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: edit tag";
		$data['heading'] = "Edit tag"; 	
		# run some DB queries for passing to the page content
		# get most popular tags - query sort descending by count of tag use
		$data['tags_query'] = $this -> ResourceDB_model -> get_tags_used('count desc');
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; 
		$data['active_leftnav'] = "Resource admin"; 
		$data['active_submenu'] = "Tags"; 
		$template['content'] = $this -> load -> view('admin/edit_tag_view', $data, TRUE);
		
		# ==== FORM VALIDATION ======
		$this->form_validation->set_rules('tagname', 'Tag name', "required|trim|xss_clean");
		
		# If the form doesn't validate, or indeed hasn't even been submitted, 
		# (re)populate with user data
		if ($this->form_validation->run() == FALSE)
		{
			$data ['error'] = validation_errors();	
			# Load page data into template - the view will be called at function end
			$template['content'] = $this -> load -> view('admin/edit_tag_view', $data, TRUE);
		}	
		
		# If form validates, update record
		else
		{
	
			$record_data = array (
						'name' => $_POST['tagname'], 
						);
						
			# Run update query in model
			$this -> Edit_model -> update_tag($record_data, $tag_id);
		
			# Set messages etc for the result page
			$data['title'] = "Edit tag: result";
			$data['heading']  = "Edit tag: result";
			$data['tagname'] = $record_data['name'];
			$data['tag_id'] = $tag_id; 
			$data['message'] = 'Tag edited ok'; 	
			# Load results page with data array
			$template['content'] = $this->load->view('admin/edit_tag_result_view', $data, TRUE);
		}
		

		# Put the content into the second template
		$this -> load -> view('template2_view', $template);		
	
	}
	
	/**
	* List resource titles by tag or subject.
	* Also get the subject or tag name for display in a 'browse results' page
	* @param string $type Values: 'tag', 'subject'
	* @param int $id Primary key from KEYWORD or SUBJECT
	*/
	function list_titles($type, $id)
	{
		if ($type == "tag")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('tag', $id, 'title');
			$qry = $this -> ResourceDB_model -> get_tag_record($id);
			$row = $qry -> row();
			$title = $row -> name;
		}
		if ($type == "subject")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('subject', $id, 'title');
			$qry = $this -> ResourceDB_model -> get_subject_record($id);
			$row = $qry -> row();
			$title = $row -> title;
		}
		if ($type == "type")
		{
			$data['query'] = $this -> ResourceDB_model -> get_titles_by_browse('type', $id, 'title');
			$qry = $this -> ResourceDB_model -> get_type_record($id);
			$row = $qry -> row();
			$title = $row -> title;			
			
		}
		$data['title'] = 'Resource DB: browse by ' . $type . " \"" . $title . "\"";
		$data['heading'] = 'Resource DB: browse by ' . $type . " \"" . $title . "\"";
		$this->load->view('resourcedb/listview', $data);
	}

}
?>
