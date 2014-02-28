<?php
class Comment extends CI_Controller {

	# Constructor. Not needed in this case, included for show. 
	# Note that if you have a constructor you need to explicitly call its
	# parent to inherit its methods and properties, otherwise they'll be locally overridden
	function Comment()
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

	
	function index($resource_id)
	{
		$data['title'] = 'Resource database: comments';
        $data['heading'] = 'Comments';
		$data['query'] = $this -> ResourceDB_model -> get_public_resources();
		$data['comments_query'] = $this -> ResourceDB_model -> get_comments($resource_id);
		$this->load->view('resourcedb/commentview', $data);
	}
	
	
	/**
	* Add a comment to a resource
	* @param int $resource_id ID of resource being commented on
	*/
	function insert($resource_id)
	{
		# Get posted comment and current user ID
		$comment = $_POST['comment'];
		$user_id = $_POST['user_id'];
		# Get title of resource for display
		$q = $this -> ResourceDB_model -> get_resource_detail($resource_id);
		$resource_title = $q -> row() -> title;
		$data['title'] = 'Resource database: comments';
        $data['heading'] = "Comments on \"" . $resource_title . "\"";
		$data['resource_id'] = $resource_id;
		# Add a record to the RESOURCE_COMMENT table, linking to the user ID
		$this -> ResourceDB_model -> insert_comment($resource_id, $comment, $user_id);
		$data['comments_query'] = $this -> ResourceDB_model -> get_comments($resource_id);
		$this->load->view('resourcedb/commentview', $data);
	
	}
	
	
	/**
	* View comments for the resource, plus optionally a form to add a comment
	* @param int $resource_id ID of resource with comments
	*/
	function view($resource_id)
	{
		$q = $this -> ResourceDB_model -> get_resource_detail($resource_id);
		$resource_title = $q -> row() -> title;
		$data['title'] = 'Resource database: comments';
        $data['heading'] = "Comments on \"" . $resource_title . "\"";
		$data['resource_id'] = $resource_id;
		$data['comments_query'] = $this -> ResourceDB_model -> get_comments($resource_id);
		$this->load->view('resourcedb/commentview', $data);
	
	}
	
}
?>
