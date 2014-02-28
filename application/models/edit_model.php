<?php
/**
* Model for resource and metadata editing: insert, update, delete. 
* 
* @author Fred Riley <fred.riley@nottingham.ac.uk>
* @version 1.0
* @package Global Health
*/

class Edit_model extends CI_Model 
{

	# Constructor 
    function Edit_model()
    {
        parent::__construct();
		$tbl_prefix = $this -> config -> item('table_prefix');
    }
	
	/**
	* Add a tag to the KEYWORD table
	* Called by input forms after checking that the tag
	* doesn't already exist
	* @param string $tag
	* @return int | boolean ID of newly-created record, else false if insert failed
	*/
	function add_tag($tag)
	{
		$data = array ('name' => $tag);
		$insert_query = $this -> db -> insert('gh_keyword', $data);
		# Get id of inserted tag (0 if failed)
		$id = $this -> db -> insert_id();
		if ($id == 0)
			{ return FALSE; }
		else { return $id; }
	}
	
	/**
	* Attach a subject to a resource 
	* Create a record in the GH_RESOURCE_KEYWORD junction table to attach 
	* a subject to a resource, or to put it another way, to categorise 
	* a resource by one or more subjects
	* @param int $resource_id ID of resource record
	* @param int $subject_id ID of subject record
	* @return boolean If insert failed return false, else true (even if nowt done)
	*/
	function attach_subject($resource_id, $subject_id)
	{
		# Check that the subject's not already attached. If so, do nowt, 
		# if not, add a row to the junction table
		$this -> db -> where ('resource_id', $resource_id);
		$this -> db -> where ('subject_id', $subject_id);
		$query = $this -> db -> get ('gh_resource_subject');
		# insert row in junction table
		if ($query -> num_rows() == 0)
		{
			$data = array ('resource_id' => $resource_id, 
							'subject_id' => $subject_id);
			$insert_query = $this -> db -> insert ('gh_resource_subject', $data);	
			# if insert failed then affected rows would be 0 so return false
			if ($this->db->affected_rows() == 0)
				{ return FALSE; }
		}
		# Either insert worked or nowt done, so return true	
		return TRUE;
	}
	
	/**
	* Attach a tag to a resource
	* Create a record in the GH_RESOURCE_KEYWORD junction table to attach 
	* a tag to a resource
	* @param int $resource_id ID of resource record
	* @param int $tag_id ID of tag record
	*/
	function attach_tag($resource_id, $tag_id)
	{
		# Check that the tag's not already attached. If so, do nowt, 
		# if not, add a row to the junction table
		$this -> db -> where ('resource_id', $resource_id);
		$this -> db -> where ('keyword_id', $tag_id);
		$query = $this -> db -> get ('gh_resource_keyword');
		if ($query -> num_rows() == 0)
		{
			$data = array ('resource_id' => $resource_id, 
							'keyword_id' => $tag_id);
			$this -> db -> insert ('gh_resource_keyword', $data);	
		}
		
	}
	
	/* ------- TO DO: INTEGRATE ALL DELETE FUNCTIONS BELOW INTO ONE ---- */
	/** 
	* Delete a subject record
	* @param int $id ID of record to be deleted
	* @return bool True if successful, else false
	*/
	function delete_subject($id)
	{
		
		$this -> db -> where('id', $id);
		 if ($this -> db -> delete('gh_subject'))
			return true;
		else
			return false;
	
	}
	
	function delete_tag($id)
	{
		$this -> db -> where('id', $id);
		 if ($this -> db -> delete('gh_keyword'))
			return true;
		else
			return false;	
	
	}

	/**
	* Detach a subject from a resource
	* Delete a record in the GH_RESOURCE_SUBJECT junction table to detach 
	* a subject from a resource
	* @param int $resource_id ID of resource record
	* @param int $subject_id ID of subject record
	*/	
	function detach_subject($resource_id, $subject_id)
	{
		$this -> db -> where ('resource_id', $resource_id);
		$this -> db -> where ('subject_id', $subject_id);
		$query = $this -> db -> delete ('gh_resource_subject');		
	}

	/**
	* Detach a tag from a resource
	* Delete a record in the RESOURCE_KEYWORD junction table to detach 
	* a tag from a resource
	* @param int $resource_id ID of resource record
	* @param int $tag_id ID of tag record
	*/	
	function detach_tag($resource_id, $tag_id)
	{
		$this -> db -> where ('resource_id', $resource_id);
		$this -> db -> where ('keyword_id', $tag_id);
		$query = $this -> db -> delete ('gh_resource_keyword');		
	}
	
	/**
	* Return all tags from the KEYWORDS table linked to resources (not RLOs)
	*
	* Used primarily in autocomplete. 
	* There'a similar function in resourcedb_model.php which gets tags by resource id
	* Requires joining RESOURCE and KEYWORD tables
	* @return mixed $query Array of objects
	*/
	function get_resource_tags()
	{
		$this->db->select('*');
		$this->db->from('gh_keyword');	
		$this->db->join('gh_resource_keyword', 'gh_resource_keyword.keyword_id = gh_keyword.id');
		$query = $this -> db -> get();
		return $query;
	}
	
	/**
	* Insert a record into RESOURCE table
	* @param mixed $data Associative array (usually from $_POST) with record data
	* @return int | boolean ID of newly-created record, else false if insert failed
	*/
	function insert_resource($data)
	{
		# Insert the record and get the new ID
		$q = $this -> db -> insert('gh_resource', $data);
		# If the query failed return an error, else return the new row id
		$id = $this -> db -> insert_id();
		if ($id == 0)
		{	return FALSE; }
		else 
		{ return $id; }
	}
	
	/**
	* Insert a record into the subject table
	* @param mixed $data Associative array (usually from $_POST) with record data
	* @return int | boolean ID of newly-created record, else false if insert failed
	*/
	function insert_subject($data)
	{
		# Insert the record and get the new ID
		$q = $this -> db -> insert('gh_subject', $data);
		# If the query failed return an error, else return the new row id
		$id = $this -> db -> insert_id();
		if ($id == 0)
		{	return FALSE; }
		else 
		{ return $id; }
	}
	
	
	/**
	* Search resource titles for full string match
	* 
	* Searches public and restricted resources 
	* Similar to search_title in ResourceDB_model but that searches for 
	* substrings in public unrestricted titles. 
	* Used in form validation for insert and edit forms
	* @param string $str Title string to match
	* @return mixed Array of objects
	*/
	function title_search($str)
	{
		$this -> db -> where ('title', $str);
		$query = $this -> db -> get('gh_resource');		
		return $query;
	}
	
	
	/* TO DO: INTEGRATE THE FOLLOWING UPDATE FUNCTIONS INTO ONE update_table($table, $data, $id) FUNCTION */
	/**
	* Updates a record in the RESOURCE table
	* @param mixed $data Associative array (usually from $_POST) with record data
	* @param int $resource_id ID of the resource record
	* @return mixed Array of objects
	*/	
	function update_key_area($data, $id)
	{
		# Update the record 
		$this -> db -> where('id', $id);
		$query = $this -> db -> update('gh_key_area', $data);
		return $query;		
	}

	
	/**
	* Updates a record in the RESOURCE table
	* @param mixed $data Associative array (usually from $_POST) with record data
	* @param int $resource_id ID of the resource record
	* @return mixed Array of objects
	*/	
	function update_resource($data, $id)
	{
		# Update the record 
		$this -> db -> where('id', $id);
		$query = $this -> db -> update('gh_resource', $data);
		return $query;		
	}

	/**
	* Updates a record in the subject table
	* @param mixed $data Associative array (usually from $_POST) with record data
	* @param int $id ID of the subject record
	* @return mixed MySQL query object
	*/	
	function update_subject($data, $id)
	{
		# Update the record 
		$this -> db -> where('id', $id);
		$query = $this -> db -> update('gh_subject', $data);
		return $query;		
	}

	
	/**
	* Update a record in the keyword table
	* @param mixed $data  Associative array (usually from $_POST) with record data
	* @param int $id ID of keyword
	* @return mixed MySQL result array
	*/
	function update_tag($data, $id)
	{
		# Update the record 
		$this -> db -> where('id', $id);
		$query = $this -> db -> update('gh_keyword', $data);
		return $query;		
	
	}

}
	
?>