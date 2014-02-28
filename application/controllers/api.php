<?php

/**
* Global Health API controller
* Generate RSS feeds for harvesting based on parameters

*/

class Api extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		$this -> load -> helper('html');
		# Debugging
		//$this->output->enable_profiler(TRUE);
		# Load date helper for date formatting in views
		$this -> load -> helper('date');
		# Load XML helper to help with RSS formatting
		$this -> load -> helper('xml');

	}
	
	
	public function index()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: API";
		$data['heading'] = "Application Programming Interface (API)"; 		
		// for <meta> tags and DC
		$data['description'] = "Harvest and customise Dublin Core-enriched RSS newsfeeds from the Global Health repository, to incorporate into external systems";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease, API, harvesting";
		$data['active_topnav'] = "News"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = ""; // active menu item
		$template['content'] = $this -> load -> view('api/api_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	
	}
	
	/**
	* Generate DC-enriched RSS feed of all resources, sorted alphabetically by title
	*/
	public function all()
	{
		$this -> load -> model ('ResourceDB_model');
		$data['query'] = $this -> ResourceDB_model -> get_public_resources();
		$data['build_date'] = now();
	    $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'Global Health repository resource metadata';
        $data['feed_url'] = site_url() . "api/all";
		$data['feed_subject'] = "Global health";
        $data['feed_description'] = "Global Health repository harvestable RSS feed. All resources sorted alphabetically by title.";
        $data['feed_language'] = 'en-gb';
        $data['creator_email'] = 'fred dot riley at gmail dot com>';	
		header("Content-Type: application/rss+xml");
		$this -> load -> view('api/all_rss_view', $data);
	
	}
	
}	
	
?>