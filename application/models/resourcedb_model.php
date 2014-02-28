<?php

# Model for Global Health repository
# CI Active Record class used extensively throughout - see 
# http://ellislab.com/codeigniter/user-guide/database/active_record.html

class ResourceDB_model extends CI_Model 
{

    function ResourceDB_model()
    {
        parent::__construct();
		$this -> load -> helper('date');
    }
	
	/** 
	* Delete a resource record
	* @param int $resource_id ID of record to be deleted
	* @return bool True if successful, else false
	*/
	function delete_resource($resource_id)
	{
		
		$this -> db -> where('id', $resource_id);
		 if ($this -> db -> delete('gh_resource'))
			return true;
		else
			return false;
	
	}
	
	/**
	* Get all data in gh_country table
	* See also get_user_country below. 
	*/
	function get_countries()
	{
		$query = $this -> db -> get('gh_country');	
		return $query;	
	}
	
	/**
	* Return the key areas (aka top level categories)  in the repository. 
	* There shouldn't be more than a handful of these. 
	* @param str $order_by How to order results
	* @return mixed MySQL query object
	*/
	function get_key_areas($order_by = "title asc")
	{
		$this -> db -> order_by($order_by);
		$query = $this -> db -> get("gh_key_area");
		return $query;
	
	}	
	
	/**
	* Get all the child categories of a key area (top-level category)
	* @param int $id ID of key area
	* @param string $order_by ORDER BY clause
	* @return mixed MySQL query object.  
	*/
	function get_key_area_children($id, $order_by="title asc")
	{
		$this -> db -> where('key_area', $id);
		$this -> db -> order_by($order_by);
		$query = $this -> db -> get('gh_subject');
		return $query; 
	
	}
	
	/**
	* Get a single record from key area table, by the key area title
	* @param string $title Key area title
	* @return mixed $query Record data as object
	*/
	function get_key_area_by_title($title)
	{
		$this -> db -> where('title', $title);
		$query = $this -> db -> get ('gh_key_area');
		return $query;
	
	}
	
	/**
	* Get a single record from key area table, mainly to find a title from an id
	* @param int $id Primary key 
	* @return mixed $query Record data as object
	*/
	function get_key_area_record($id)
	{
		$this -> db -> where ('id', $id);
		$query = $this -> db -> get("gh_key_area");
		return $query; 
	}
	
	/**
	* Get resources categorised in a key area
	* key_area is a foreign key in the subject table, so 
	* just need to joing subject and resources tables on the key area id
	* @param int $key_area_id Key area id
	* @param int $limit Number of records to return
	* @param int $offset Result offset - start at the nth record returned 
	* @param string $order_by Value for ORDER BY condition of query
	* @return mixed MySQL query object with all resource records
	*/
	function get_key_area_resources($key_area_id, $offset = 0, $limit = 1000000, $order_by = "title asc")
	{
		# Use subqueries to get resources in a key area
		# SQL comments left in for a bit of clarity
				
		$qry = "SELECT R.* 
				FROM gh_resource R 
				WHERE R.id IN 

				-- get resource IDs for a subject
				(SELECT RS.resource_id 
				FROM gh_resource_subject RS 
				WHERE RS.subject_id IN 

				-- get subject IDs for a key area
				(SELECT S.id AS subject_id 
				FROM gh_subject S 
				WHERE S.key_area = $key_area_id))

				LIMIT $offset, $limit";
				
		$query = $this -> db -> query($qry);
		return $query;
	
	}
	
	
	/**
	* Get comments for a resource
	* Not wanted in the Global Health project - retained but 
	* commented out, in case needed in future. 
	*
	* @param int $resource_id ID of resource
	* @return mixed $query Array of objects
	*/
/* 	function get_comments($resource_id)
	{
		# Set up a where condition to only show comments for a specific resource
		# Comment id is in 3rd segment of URL
		$this -> db -> where ('resource_id', $resource_id);
		$query = $this -> db -> get('gh_comment');
		return $query;
	}
*/
	
	/**
	* Get all records from the origin table
	* This spacifies where the resource is coming from 
	* eg external source, clinicalskills.net, etc
	* @return mixed $query Object with record data
	*/
	function get_origins()
	{
		$query = $this -> db -> get('gh_origin');	
		return $query;
	}
	
	/**
	* Get details of a particular resource origin, by id
	* @param int $id ID of resource origin in origin table
	* @return mixed $query Object with record data
	*/
	function get_origin($id)
	{
		$this -> db -> where ('id', $id);
		$query = $this -> db -> get('gh_origin');
		return $query;
	
	}
	
	
    /**
	* Get all publicly-available records from RESOURCE table
	* @param int $numrecs Number of resources to return, default set effectively to all
	* @param string $order_by Attribute to order the results by
	* @return mixed $query Array of objects
	*/
	function get_public_resources($numrecs = 1000000, $order_by = "title asc")
    {
	
		# Sorting by title? Use custom query to ignore 'the' at the 
		# start of a resource title when alphabetising. 
		# Used SQL code rather than active record for clarity as the 
		# 'case' clause is a bit fiddly
		$qry = "SELECT * from gh_resource"; 
		if ($order_by == "title asc" )
		{
			$order_by = "ORDER BY (case when title like 'The %' then substring(title, 5, 1000) else title end) asc ";
		}
		elseif($order_by == "title desc")
		{
			$order_by = "ORDER BY (case when title like 'The %' then substring(title, 5, 1000) else title end) desc ";
		}
		else
		{
			$order_by = "ORDER BY " . $order_by; 
		}
		# Only show non-restricted and visible resources 
		$qry .= " WHERE (restricted=0 AND visible=1) " . $order_by . " LIMIT " . $numrecs;
		$query = $this -> db -> query($qry);
		return $query;
	}
	
	/** Get resource record by its title
	* @param string $title Resource title
	* Used in resource insert form title check via Ajax
	* @return bool|mixed MySQL query object if successful, else false
	*/
	function get_resource_by_title($title)
	{
		$this -> db -> where('title', $title);
		$query = $this -> db -> get('gh_resource');
		if ($query->num_rows() > 0)
		{ 
			return $query; 
		}
		else
		{
			return false;
		}
	
	}
	
	
	
   /**
	* Get all resource records from RESOURCE table
	* All resources returned, regardless of visibility or restrictedness. 
	* Custom query used to generate alphabetical list ignoring "the" or "a" at the 
	* start of a title. See Stackoverflow query at:
	* http://stackoverflow.com/questions/16044637/sort-list-alphabetically-ignoring-the
	* @param int $limit Number of records to return
	* @param int $offset Result offset - start at the nth record returned 
	* @return mixed $query MySQL query object
	*/
	function get_resources($limit = 1000000, $offset = 0, $order_by = "title asc")
    {

		# Sorting by title? Use custom query to ignore 'the' at the 
		# start of a resource title when alphabetising. 
		if ($order_by == "title asc")
		{
			$qry = "SELECT * from gh_resource ORDER BY
			(case when title like 'The %' then substring(title, 5, 1000) else title end) asc 
			LIMIT $offset, $limit ";
			$query = $this -> db -> query($qry);
		}
		elseif ($order_by == "title desc" )
		{
			$qry = "SELECT * from gh_resource ORDER BY
			(case when title like 'The %' then substring(title, 5, 1000) else title end) asc 
			LIMIT $offset, $limit ";
			$query = $this -> db -> query($qry);
		}
		# Sorting by id, say? Use active record.
		else
		{
			$this -> db -> limit($limit, $offset);
			$this -> db -> order_by($order_by);	
			$query = $this->db->get('gh_resource');
		}
		return $query;
	}	
	
	/**
	* Return all fields from a resource 
	* 
	* @param int $resource_id ID of resource
	* @return mixed $query Object with record data
	*/
	function get_resource_detail($resource_id)
	{
		$this -> db -> where('id', $resource_id);		
		$query = $this -> db -> get('gh_resource');
		return $query;
	}

	/**
	* Get titles and keys of resource types
	* @param bool $used Set true if only want to get types with 
	* resources attached, false if want to get all types
	* Note that type is a foreign key (type int) in RESOURCE, so a resource can only
	* be of one type, and no joins are needed. 
	* @return mixed $query Array of objects
	*/
	function get_resource_types($used = TRUE)
	{
		if ($used)
		{
			# Use a subquery to only find resource types 'containing'
			# at least one resource
			$qry = "select id, title from gh_type
					where id in 
					(select distinct type from gh_resource ) 
					order by title";
			$query = $this -> db -> query ($qry);
		}
		else
		{
			$this -> db -> order_by('title', 'asc');
			$query = $this -> db -> get('gh_type');
		}
		return $query;		
		
	}
	
	/**
	* Get subjects a resource belongs to. 
	* Join SUBJECT and RESOURCE_SUBJECT
	* @param int $resource_id ID of resource
	* @return mixed $query Object with record data.
	*/
	function get_resource_subjects($resource_id)
	{
		$this->db->select('gh_subject.*');
		$this->db->from('gh_subject');	
		$this->db->join('gh_resource_subject', 'gh_resource_subject.subject_id = gh_subject.id');
		$this->db->where('gh_resource_subject.resource_id', $resource_id);
		$query = $this -> db -> get();
		return $query;	
	
	}
	
	
	/**
	* Get tags a resource is tagged with. 
	* Join KEYWORD and RESOURCE_KEYWORD on keyword_num. The select is from
	* the main KEYWORD table so as to get tag IDs and titles. 
	* @param int $resource_id ID of resource
	* @return mixed $query Object with record data.
	*/
	function get_resource_tags($resource_id)
	{
		$this->db->select('*');
		$this->db->from('gh_keyword');	
		$this->db->join('gh_resource_keyword', 'gh_resource_keyword.keyword_id = gh_keyword.id');
		$this->db->where('gh_resource_keyword.resource_id', $resource_id);
		$query = $this -> db -> get();
		return $query;	
	
	}
	

	
	/**
	* Return all 3 fields from a resource_type record specified by id
	* NB: get_resource_type() is a PHP function, hence the shortened func name below
	* @param int $id ID of record
	* @return mixed $query Object with record data
	*/
	function get_res_type($id)
	{
		$this -> db -> where('id', $id);
		$query = $this -> db -> get('gh_type');
		return $query;
		
	}
	

	/**
	* Get titles and keys of subjects
	* @param bool $used Set true if only want to get subjects with 
	* resources attached, false if want to get all subjects
	* @return mixed $query Array of objects
	*/
	function get_subjects($used = TRUE)
	{
		if ($used)
		{
			# Join subject and resource_subject to only select titles 
			# with resources attached
			$qry = "SELECT distinct S.*  
					from gh_resource_subject RS, gh_subject S 
					where S.id = RS.subject_id 
					order by title";
		}
		else
		{
			$qry = "select * from gh_subject order by title";
		}
		
		$query = $this -> db -> query ($qry);
		return $query;
	}
	
	/**
	* Get a subject table record from the subject title. Title is unique so 
	* the query should only ever return one row. 
	* @param string $title Subject title to search for
	* @return bool|mixed If successful return the subject record, else return false
	*/
	function get_subject_by_title($title)
	{
		$this -> db -> where ('title', $title);
		$query = $this -> db -> get("gh_subject");
		if ($query -> num_rows() > 0)
		{
			return $query; 	
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	* Get resources categorised in a subject (eg "urbanisation")
	* Join resources, resource_subject and subject tables
	* @param int $subject_id Primary key of subject table
	* @param string $order_by Value for ORDER BY condition of query
	* @param int $numrecs Number of resources to return. 
	* @return mixed $query MySQL query object
	*/
	function get_subject_resources($subject_id, $order_by = "title asc", $numrecs = 1000000)
	{
		$qry = "SELECT R.id, R.title from gh_resource R, gh_subject S, gh_resource_subject RS 
				WHERE S.id = RS.subject_id AND RS.resource_id = R.id AND S.id = " . $subject_id . " 
				ORDER BY " . $order_by . " LIMIT " . $numrecs;
		$query = $this -> db -> query ($qry);
		return $query;	
	}
	
	/**
	* Get a single record from SUBJECT, mainly to find a title from an id
	* @param int $id Primary key 
	* @return mixed $query Record data as object
	*/
	function get_subject_record($id)
	{
		$this -> db -> where ('id', $id);
		$query = $this -> db -> get("gh_subject");
		return $query; 
	}

	
	/**
	* Get tags attached to resources, and number of taggings.
	* Retrieve tag names and IDs from keyword table, then join with 
	* resource_keyword to find discover number of times tag used. 
	* NB: returns *used* tags only, ie tags attached to resources.
	* To get all tags, use get_tags_all() below
	* @param int $num_tags Number of tags to return, default 'all' 
	* @param string $order_by Field to order by and how ordered. 
	* eg 'count asc' would order by least popular tags
	* @return mixed $query Object with record data. Fields: tagname, id, count
	*/
	function get_tags_used($order_by = "tagname asc", $limit = 1000000, $offset = 1)
	{
		$qry = "SELECT K.name as tagname, RK.keyword_id AS id, COUNT(RK.keyword_id) AS count
					FROM gh_resource_keyword RK, gh_keyword K 
					WHERE RK.keyword_id = K.id 
					GROUP BY K.id
					ORDER BY $order_by 
					LIMIT $offset, $limit";

		$query = $this -> db -> query ($qry);
		return $query;
		
	}
	
	/**
	* Return all tags in the repository, used or not. 
	* @param int $limit Number of records to return
	* @param int $offset Where to start recordset
	* @param str $order_by How to order the results
	* @return mixed MySQL query object
	*/
	function get_tags_all($limit = 1000000, $offset = 0, $order_by = "name asc")
	{
		$this -> db -> order_by($order_by);
		$this -> db -> limit($limit, $offset);
		$query = $this -> db -> get('gh_keyword');
		return $query;
	}
	
	/**
	* Get ID of a tag from its name
	* Useful in input forms for seeing if a tag already exists
	* @param string $name Title of tag
	* @return mixed Query object
	*/
	function get_tag_id($name)
	{
		$this -> db -> where ('name', $name);	
		$query = $this -> db -> get('gh_keyword');
		return $query;
	}
	

	/**
	* Get a single record from KEYWORD, mainly to find a title from an id
	* @param int $id Primary key 
	* @return mixed $query Record data as object
	*/
	function get_tag_record($id)
	{
		$this -> db -> where ('id', $id);
		$query = $this -> db -> get("gh_keyword");
		return $query; 
	}
	
	
	/**
	* Get resources by subject, tag or resource type
	* @param string $browsetype Values: 'tag', 'subject', 'type', 'editor'
	* @param int $id Primary key from KEYWORD or SUBJECT
	* @param string $order Field to order results by
	* @return mixed $query Array of objects
	*/
	function get_titles_by_browse($browsetype='tag', $id, $order='title')
	{
		$this->db->select('*');
		$this->db->from('gh_resource');
		switch($browsetype)
		{
			case 'tag': 
				$this->db->join('gh_resource_keyword', 'gh_resource_keyword.resource_id = gh_resource.id');
				$this->db->where('gh_resource_keyword.keyword_id', $id);
				break;
			case 'subject':
				$this->db->join('gh_resource_subject', 'gh_resource_subject.resource_id = gh_resource.id');
				$this->db->where('gh_resource_subject.subject_id', $id);
				break;
				
			case 'type':
				$this -> db -> where('type', $id);
				break;
				
			case 'editor':
				$this -> db -> where('metadata_author', $id);
				break;
		}
		# Only show non-restricted and visible resources 
		$this -> db -> where('restricted', 0);
		$this -> db -> where('visible', 1);
		# Multiple order by options expected in the future, hence switch
		switch ($order)
		{
			case 'title': 
				$this -> db -> order_by('title', 'asc');
				break;
		
		}
		$query = $this->db->get();
		return $query;
		
	}	
	
	/**
	* Get record details for a given title.
	* Also used to find if a title exists already
	* @param string $str Title string to search for
	* @return mixed Query object
	*/
	function get_title($str)
	{
		$this -> db -> select('*');
		$this -> db -> from ('gh_resource');
		$this -> db -> where('title', $str);
		$query = $this -> db -> get();
		return $query;
	}

	
	/**
	* Get a single record from RESOURCE_TYPE, mainly to find a title from an id
	* @param int $id Primary key 
	* @return mixed $query Record data as object
	*/
	function get_type_record($id)
	{
		$this -> db -> where ('id', $id);
		$query = $this -> db -> get("gh_type");
		return $query; 
	}	
	
	/**
	* Get the user's country. 
	* Join gh_user and gh_country
	* @param int $user_id User ID
	* @return mixed $query Record data as object
	*/
	function get_user_country($user_id)
	{
		$this->db->select('*');
		$this->db->from('gh_country');	
		$this->db->join('gh_users', 'gh_users.country = gh_country.id');
		$this->db->where('gh_users.id', $user_id);	
		$query = $this->db->get();
		return $query;
	}
	
	
	/**
	* Insert a comment on a resource
	* @param int $resource_id ID of resource being commented upon
	* @param string $comment Comment being made on the resource
	* @param int $author_id ID of logged-in user making comment
	*/
	function insert_comment($resource_id, $comment, $author_id)
	{
		# Use date helper function to format current timestamp for mySQL
		# Get current time from PHP time() function which returns a Unix timestamp.
		$now = time();
		# unix_to_human() will return a timestamp of the form YYYY-MM-DD HH:MM:SS 
		# which fits a mySQL DATETIME data type
		$date = unix_to_human($now, TRUE, 'eu');
		$data = array(
			'resource_id' => $resource_id ,
			'body' => $comment,
			'user_id' => $author_id, 
			'date' => $date
            );
		$this -> db -> insert('gh_comment', $data);
	
	}

	/**
	* Find resources by tag name, with full or partial tagname supplied
	* Use in search controller, called by main resource search form
	* @param string $substring Tag string
	* @return mixed MySQL query object - do num_rows testing in controller or view 
	*/
	function search_resources_by_tag_substring($substring)
	{
		# Join tag, resource and resource_keyword (junction) tables
		$qry = "SELECT R.title, R.id 
				FROM `gh_keyword` K, `gh_resource_keyword` RK, gh_resource R 
				WHERE K.id = RK.keyword_id 
				AND R.id = RK.resource_id 
				AND K.name like '%" . $substring . "%'";
		$query = $this -> db -> query($qry);
		return $query; 
	
	}
	
	/**
	* Perform a substring search for a resource title
	* Only titles which are public and unrestricted are searched
	* @param string $search_str Title string
	* @return mixed $query Array of objects
	*/
	function search_title($search_str)
	{
		$this -> db -> like ('title', $search_str);
		# Only show non-restricted and visible resources 
		$this -> db -> where('restricted', 0);
		$this -> db -> where('visible', 1);
		$query = $this -> db -> get('gh_resource');		
		return $query;
	}
	
	/**
	* Perform a substring search for a resource url
	* Only records which are public and unrestricted
	* @param string $search_str Title string
	* @return mixed $query Array of objects
	*/
	function search_url($search_str)
	{
		$this -> db -> like ('url', $search_str);
		# Only show non-restricted and visible resources 
		$this -> db -> where('restricted', 0);
		$this -> db -> where('visible', 1);
		$query = $this -> db -> get('gh_resource');		
		return $query;
	}
	
	/** 
	* Just get a count of records in a table
	* Used for instance to paginate query results, especially of resources
	* @param str
	* @return int Number of rows in the table
	*/
	function table_count($table_name = "gh_resource")
	{
		return $this -> db -> count_all($table_name);
	}
	
}

?>