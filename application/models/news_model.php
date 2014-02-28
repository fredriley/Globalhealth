<?php
/**
* Global Health repository news system model
* Adapted from simple news system tutorial on the CI site at 
* http://ellislab.com/codeigniter/user-guide/tutorial/
* The main adaptation is that the parameter passed to get_news() isn't the 
* item 'slug' but its ID. The 'slug' has been ditched from all scripts, 
* because it's unsuitable for this project and generates unwieldy URLs (and 
* fails when the slug contains forbidden chars such as @)

*/
class News_model extends CI_Model 
{

	public function __construct()
	{
		# Load date helper for writing posted and edited dates to the DB
		$this -> load -> helper('date');
	}
	
	/**
	* Delete a news item 
	* @param int $item_id ID of item to delete
	* @return bool True if successful, else false
	*/
	public function delete_news($item_id)
	{
		$this -> db -> where('id', $item_id);
		return $this -> db -> delete('gh_news');

	}

	/**
	* Get all, or a single, news item, sorted by posted date descending (latest post first)
	* @param bool|int $item_id ID of news item in table, or all items if false
	* @param int $num_items Number of items to return - if null, return all. 
	* @return mixed MySQL query object
	*/
	public function get_news($item_id = FALSE, $num_items = null)
	{

		if (!is_null($num_items))
		{
			$this -> db -> limit($num_items);
		}
		if ($item_id === FALSE)
		{
			$query = $this->db->get('gh_news');
			//return $query->result_array();
			return $query;
		}
		$this -> db -> order_by('posted', 'asc');
		$query = $this->db->get_where('gh_news', array('id' => $item_id));
		//return $query->row_array();
		return $query;
	}	
	
	/**
	* Get the newest news post by posted date
	* Used to get latest posted date for the RSS newsfeed
	* @return mixed MySQL query object
	*/
	public function get_newest_post()
	{
		$this -> db -> select_max('posted');
		$query = $this -> db -> get('gh_news');
		return $query;
	}
	
	
	/**
	* Create a news item record
	* The post() method of the input class sanitises input against attacks
	*/ 
	public function set_news()
	{
		$this->load->helper('url');
		
		# What's the current date and time? Use the date helper - 
		# now() returns current time as Unix timestamp, unix_to_human
		# converts it to YYYY-MM-DD HH:MM:SS which mySQL needs for the 
		# DATETIME data type
		$now = 	unix_to_human(now(), TRUE, 'eu'); // Euro time with seconds

		
		$data = array(
			'title' => $this->input->post('title'),
			'text' => $this->input->post('text'), 
			'posted' => $now, 
			'edited' => $now
		);
		
		return $this->db->insert('gh_news', $data);
	}
	
	public function edit_news($item_id)
	{
		$this -> load -> helper('url');
		
		# What's the current date and time? Use the date helper - 
		# now() returns current time as Unix timestamp, unix_to_human
		# converts it to YYYY-MM-DD HH:MM:SS which mySQL needs for the 
		# DATETIME data type
		$now = 	unix_to_human(now(), TRUE, 'eu'); // Euro time with seconds
	
		$data = array(
			'title' => $this->input->post('title'),
			'text' => $this->input->post('text'), 
			//'posted' => $now, 
			'edited' => $now
		);
		$this -> db -> where('id', $item_id);
		return $this -> db -> update('gh_news', $data);	
	
	}
	
}










?>