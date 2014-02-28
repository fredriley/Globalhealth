<?php
class Feed extends CI_Controller {

	# Code adapted from http://www.derekallard.com/blog/post/building-an-rss-feed-in-code-igniter/

	public function __construct()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('gh_resource');
		# Load URL and form helper classes	
		$this -> load -> helper('xml');
		$this -> load -> helper('date');
		$this -> load -> helper('url');
		$this->load->model('feed_model');
		//$this -> output -> enable_profiler(TRUE);

	}

	/**
	* Generate data for the RSS newsfeed. The fiddly RSS syntax is 
	* sorted in the view. 
	* @param int $num_resources Number of resources to return in the feed
	*/
    function resources($num_resources = false)
    {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'Global Health repository';
        $data['feed_url'] = site_url('resources/feed/');
        $data['page_description'] = 'Most recently-added resources to the Global Health repository';
        $data['page_language'] = 'en-uk';
        $data['creator_email'] = 'fred.riley@gmail.com';
		# Get all resource records
        $data['query'] = $this -> resourcedb_model -> get_public_resources();
		# Important header!! Doc won't be recognised as a RSS feed otherwise    
        header("Content-Type: application/rss+xml");
        $this->load->view('rssfeed_view', $data);
    }	

	
}
?>
