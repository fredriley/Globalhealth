<?php
/**
* Model for user queries. 
* User _management_ (login, registration etc) is dealt with by the ion_auth files.
* 
* @author Fred Riley <fred.riley@nottingham.ac.uk>
* @version 1.0
* @package ResourceDB
*/

class Users_model extends CI_Model 
{

	# Constructor: inherit from Model class
    function Users_model()
    {
        parent::__construct();
    }
	
	/**
	* See if a username exists, and if so return user record
	* NB: The email field is the username, _not_ the username field!
	* @param string $email Username to check (email address)
	* @return mixed $query Object with user record
	*/
	function check_username($email)
	{
		$this -> db -> where(strtolower('email'), strtolower($email));
		$query = $this -> db -> get('resourcedb_users');
		return $query; 		
	}

	/**
	* Get individual user record from user table
	* @param int $id ID of user
	* @return mixed $query Record data as object
	*/
	function get_user($id)
	{
		$this -> db -> where ('id', $id);
		$query = $this -> db -> get ('resourcedb_users');
		return $query; 
	}

	/**
	* Get all records from user table
	* @param into $id ID of user
	* @return mixed $query Record data as object
	*/
	function get_users()
	{
		$query = $this -> db -> get ('resourcedb_users');
		return $query; 
	}
	
}
	
?>