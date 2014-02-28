<?php

/**
* Global Health news system controller
* Adapted from simple news system tutorial on the CI site at 
* http://ellislab.com/codeigniter/user-guide/tutorial/
* The main adaptation is that the parameter passed to get_news() isn't the 
* item 'slug' but its ID

*/

class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		$this -> load -> helper('html');
		# Debugging
		//$this->output->enable_profiler(TRUE);
		# Load date helper for date formatting in views
		$this -> load -> helper('date');
		# Next two helpers for edit and create forms
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	/** 
	* News system - end-user view
	* Load a page with links to RSS feeds for news and harvesting
	*/
	public function index()
	{
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: news feeds and harvesting";
		$data['heading'] = "News feeds and harvesting"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "News"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "News admin"; // active menu item	
		$template['content'] = $this -> load -> view('news/index_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);	
	}
	
	
	/**
	* Display all news items
	*/
	public function items()
	{
		$data['query'] = $this -> news_model -> get_news();
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: news";
		$data['heading'] = "News from the Global Health project"; 		
		// for <meta> tags and DC
		$data['description'] = "The Global Health repository is a 'one-stop shop' for resources related to global health, with a specific emphasis on nursing's role and contribution";
		$data['keywords'] = "health, healthcare, nursing, millennium action goals, poverty, disease";
		$data['active_topnav'] = "News"; // active menu item
		$data['active_leftnav'] = ""; // active menu item
		$data['active_submenu'] = "News admin"; // active menu item
		$template['content'] = $this -> load -> view('news/news_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	}
	
	
	/** 
	* News system home
	* Restricted to admin users
	*/
	public function home()
	{
		# If the user's not logged in send them to the login page
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		# If they're logged in but not an admin send them to the home page
		elseif (!$this->ion_auth->is_admin())
		{
			redirect('/home', 'refresh');
		}
		# Get the last 6 news items as a MYSQL query object
		# First parameter can specify an item id, or just false for no item
		# Second parameter is number of items to return. 
		$data['query'] = $this -> news_model -> get_news(false, 6);

		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: news system";
		$data['heading'] = "News system: home"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = "News"; // active menu item
		$data['active_leftnav'] = "News admin"; // active menu item
		$data['active_submenu'] = "Home"; // active menu item
		$template['content'] = $this -> load -> view('news/home_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this article? You cannot undo this action.\"";
		$this -> load -> view('confirm_script_view', $script_data);

	}

	/** 
	* Display all news items with edit and delete links.
	* Only available to admins
	*/
	public function archive()
	{
		# If the user's not logged in send them to the login page
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		# If they're logged in but not an admin send them to the home page
		elseif (!$this->ion_auth->is_admin())
		{
			redirect('/home', 'refresh');
		}	
		# Get all news items as a MYSQL query object
		# get_news() without a parameter returns all items
		$data['query'] = $this -> news_model -> get_news();
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: news archive";
		$data['heading'] = "News archive"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = "News"; // active menu item
		$data['active_leftnav'] = "News admin"; // active menu item
		$data['active_submenu'] = "Archive"; // active menu item
		$template['content'] = $this -> load -> view('news/archive_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);	
		
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this article? You cannot undo this action.\"";
		$this -> load -> view('confirm_script_view', $script_data);
	}
	
	/** 
	* Delete a news article
	* Restricted to logged-in admins
	* @param int $item_id Article to be deleted
	*/
	public function delete($item_id)
	{
		# If the user's not logged in send them to the login page
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		# If they're logged in but not an admin send them to the home page
		elseif (!$this->ion_auth->is_admin())
		{
			redirect('/home', 'refresh');
		}
		
		# Get article title before deletion to show user in view
		$query = $this -> news_model -> get_news($item_id);
		if ($query->num_rows() == 0)
		{
			$data['message'] = "The article ID ". $item_id . " doesn't exist in the database, so can't be deleted. 
				Tough mazoomas.";
		}
		else
		{
			$row = $query -> row();
			$data['article_title'] = $row -> title;
			# Delete the article record from the database
			 if (!$this -> news_model -> delete_news($item_id))
			 {
				$data['message'] = "This article could not be deleted. Bummer.";
			 }
			 else
			 {
				$data['message'] = "The article \"" . $row -> title . "\" has been deleted for good. 
					It has gone to meet its maker. It's pushing up the daisies. 
					It has joined the choir invisible. It is an ex-article. <em>Requiescat in pace</em>.";
			}
		}
			// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: delete news articel";
		$data['heading'] = "Delete news article"; 		
		// for <meta> tags and DC
		$data['description'] = "T";
		$data['keywords'] = "";
		$data['active_topnav'] = "News"; // active menu item
		$data['active_leftnav'] = "News admin"; // active menu item
		$data['active_submenu'] = ""; // active menu item
		$template['content'] = $this -> load -> view('news/delete_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
	
	}

	
	/**
	* View a single news item
	* Available to all users. Code in view ensures that
	* non-admins don't see delete and edit links
	* @param int $item_id ID of item in news table
	*/
	public function article($item_id)
	{
		$data['query'] = $this->news_model->get_news($item_id);

		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: news system";
		$data['heading'] = "News article"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = "News"; // active menu item
		$data['active_leftnav'] = "News admin"; // active menu item
		$data['active_submenu'] = ""; // active menu item
		$template['content'] = $this -> load -> view('news/article_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
		if ($this -> ion_auth -> logged_in() && $this -> ion_auth -> is_admin())
		{
			# Load confirmation script for 'are you sure?' dialogue on delete
			$script_data['text'] = "\"Do you really want to delete this article? You cannot undo this action.\"";
			$this -> load -> view('confirm_script_view', $script_data);
		}
	}
	
	/**
	* Create a news item
	* Uses form validation - if validation fails, form is re-displayed with 
	* validation errors.
	* Only available to logged-in admins
	*/
	public function create()
	{
		# If the user's not logged in send them to the login page
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		# If they're logged in but not an admin send them to the home page
		elseif (!$this->ion_auth->is_admin())
		{
			redirect('/home', 'refresh');
		}
		
		# The is_unique parameter checks the title entered is unique in the call_news table
		$this->form_validation->set_rules('title', 'Title', 'required|is_unique[gh_news.title]');
		$this->form_validation->set_rules('text', 'text', 'required');
		
		# If the form doesn't validate, or indeed hasn't even been submitted, 
		# display it (again). Input and textarea elements are repopulated in the view
		# with set_value() to save the user re-inputting data. 
		if ($this->form_validation->run() === FALSE)
		{
			// define some vars to pass to the nav and page views
			$data['title'] = "Global Health: create news item";
			$data['heading'] = "Create news article"; 		
			// for <meta> tags and DC
			$data['description'] = "";
			$data['keywords'] = "";
			$data['active_topnav'] = "News"; // active menu item
			$data['active_leftnav'] = "News admin"; // active menu item
			$data['active_submenu'] = "Create"; // active menu item
			$template['content'] = $this -> load -> view('news/create_view', $data, TRUE);
			$this -> load -> view('template2_view', $template);
			# Load TinyMCE editor script
			$this -> load -> view('tinymce_script_view');
		}
		else
		{
			# Run INSERT query
			$this->news_model->set_news();
			# Get ID of last inserted record...
			$item_id = $this->db->insert_id();
			# ...then the record itself, for display to the user
			$data['query'] = $this -> news_model -> get_news($item_id);
			$data['message'] = "The news article has been successfully added to the news system. Nice one. ";
			// define some vars to pass to the nav and page views
			$data['title'] = "Global Health: news article added";
			$data['heading'] = "News article added"; 		
			// for <meta> tags and DC
			$data['description'] = "";
			$data['keywords'] = "";
			$data['active_topnav'] = "News"; // active menu item
			$data['active_leftnav'] = "News admin"; // active menu item
			$data['active_submenu'] = "Create"; // active menu item
			$template['content'] = $this -> load -> view('news/success_view', $data, TRUE);
			$this -> load -> view('template2_view', $template);
			# Load confirmation script for 'are you sure?' dialogue on delete
			$script_data['text'] = "\"Do you really want to delete this article? You cannot undo this action.\"";
			$this -> load -> view('confirm_script_view', $script_data);
		}
	}
	
	/**
	* Edit a news item
	* Restricted to logged-in admins
	* @param int $item_id ID of item to edit
	*/
	public function edit($item_id = false)
	{
		# If the user's not logged in send them to the login page
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		# If they're logged in but not an admin send them to the home page
		elseif (!$this->ion_auth->is_admin())
		{
			redirect('/home', 'refresh');
		}
		
		# No item id passed? Pack off to the 404 page
		if (!$item_id)
		{
			redirect('news/archive', 'refresh');
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		# Get news item details to fill in edit form fields
		# Query result from model as MySQL query object
		$rec = $this -> news_model -> get_news($item_id) -> row();	
		$data['id'] = $rec -> id;
		$data['news_title'] = $rec -> title;
		$data['text'] = $rec -> text;
		$data['posted'] = $rec -> posted;
		$data['edited'] = $rec -> edited;
		
		# Validation rules. 
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'text', 'required');
		
		# If the form doesn't validate, or indeed hasn't even been submitted, 
		# display it (again). In the view, set_value() calls repopulate the form 
		# with user-submitted values
		if ($this->form_validation->run() === FALSE)
		{
			// define some vars to pass to the nav and page views
			$data['title'] = "Global Health: edit news item";
			$data['heading'] = "Edit news item"; 		
			// for <meta> tags and DC
			$data['description'] = "";
			$data['keywords'] = "";
			$data['active_topnav'] = "News"; // active menu item
			$data['active_leftnav'] = "News admin"; // active menu item
			$data['active_submenu'] = "Edit"; // active menu item
			$template['content'] = $this -> load -> view('news/edit_view', $data, TRUE);
			$this -> load -> view('template2_view', $template);
			
		}
		# If the form validated, run the UPDATE query and present a success page
		else
		{
			# Run UPDATE query
			$this -> news_model -> edit_news($item_id);
			# Get updated record for display
			$data['query'] = $this -> news_model -> get_news($item_id);
			// define some vars to pass to the nav and page views
			$data['title'] = "Global Health: news item edited";
			$data['heading'] = "News item edited"; 		
			// for <meta> tags and DC
			$data['description'] = "";
			$data['keywords'] = "";
			$data['active_topnav'] = "News"; // active menu item
			$data['active_leftnav'] = "News admin"; // active menu item
			$data['active_submenu'] = "Edit"; // active menu item
			$data['message'] = "The news item has been successfully updated. Kudos."; 
			$template['content'] = $this -> load -> view('news/success_view', $data, TRUE);
			$this -> load -> view('template2_view', $template);
		
		}
		# For both edit form and success pages:
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this article? You cannot undo this action.\"";
		$this -> load -> view('confirm_script_view', $script_data);
		# Load TinyMCE editor
		$this -> load -> view('tinymce_script_view');
	}
		
	/**
	* Generate a RSS feed of news articles
	* Most of the RSS syntax is in the generic view. Code adapted from article at:
	* http://www.derekallard.com/blog/post/building-an-rss-feed-in-code-igniter
	* @param $num_articles int Number of articles to show in the feed. If false, show all. 
	*/
	public function rss($num_articles = 100000)
	{
		$this -> load -> helper('xml');
		$newest_post_query = $this -> news_model -> get_newest_post();
		$row = $newest_post_query -> row();
		$data['build_date'] = $row -> posted;
	    $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'Global Health repository news';
        $data['feed_url'] = site_url() . "news/rss";
		$data['feed_subject'] = "Global health";
        $data['feed_description'] = "News from the Global Health repository, a one-stop shop for resources related to global health, with a specific emphasis on the role and contribution of nursing'";
        $data['feed_language'] = 'en-gb';
        $data['creator_email'] = 'fred dot riley at gmail dot com>';
		# Get all news items from database
        $data['posts'] = $this -> news_model -> get_news();    
        header("Content-Type: application/rss+xml");
        $this -> load -> view('news/feed_view', $data);
	
	}
	
	
}

?>