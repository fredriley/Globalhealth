<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Site Config
*
* Author: Aaron Fecowycz
*		  aaron.fecowycz@nottingham.ac.uk
*
*
*
* Created:  20131114
*
* Description:  Storage location for useful site wide config variables
* and other functions
* Requirements: PHP5 or above
*
*/

class Site_config{
	
	var $site_admin_name = 'Aaron Fecowycz';
	var $site_admin_email = 'aaron.fecowycz@nottingham.ac.uk';
	
	function output_admin_email(){
	
		return '<a href="mailto:'.$this->site_admin_email.'">'.$this->site_admin_name.'</a>';
	
	}
	

}

?>