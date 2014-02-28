<?php
/**
* Model for newsfeeds 
* 
* @author Fred Riley <fred.riley@nottingham.ac.uk>
* @version 1.0
* @package ResourceDB
*/

class Feed_model extends CI_Model 
{

	# Constructor to inherit methods of parent class
    function Feed_model()
    {
        parent::__construct();
    }


	function getRecentRecords()
	{
		$this -> db -> order_by('metadata_created', 'desc');
		$this -> db -> where ('visible', 1);
		$this -> db -> limit (20);
		$query = $this -> db -> get ('gh_resource');
		return $query; 
	
	}
}
	
?>