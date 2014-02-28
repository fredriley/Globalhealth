<?php
/**
* Resource detail controller
* Display details of a resource record
* @package Global Health
* @version 1.0
* @author Fred Riley <fred.riley@gmail.com>
*/

class Detail extends CI_Controller {

	# Constructor. 
	function Detail()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('RESOURCE');
		# Load URL and form helper classes	
		$this -> load -> helper('url');
		$this -> load -> helper('date');
		# Load table class for displaying record detail in a table
		$this->load->library('table');
		$this->load->model('ResourceDB_model');

	}

	/**
	* Display something if the bare 'detail' URL is called
	*/
	function index()
	{
		$data['title'] = 'Resource DB: record detail';
        $data['heading'] = 'Resource DB: record detail';
		$date['message'] = "No record has been specified. ";
		$this->load->view('resourcedb/recordview', $data);
	}
	/**
	* Display a full resource record
	* @param int $resource_id ID of resource, passed in URL. Default setting is -1 to cater 
	* for URL hacking, where user calls /record/detail/ without a record ID
	*/
	function record()
	{
		# If there's no ID in the 3rd segment of the URL as there should be, maybe
		# because of URL hacking, pass an error to the view file, otherwise pass 
		# queries to it for processing and display
		$data['title'] = 'Global Health repository: record detail';
        $data['heading'] = 'Record detail';
		if (! ($resource_id = $this -> uri -> segment(3)) )
		{
			$data['error'] = "<div class=\"error\" ><p>No record ID has been specified. Try again, buster.</p></div>";
		}
		else
		{
			# Call method below to put record detail into an assoc array. If it returns false, 
			# send an error
			$resource_detail_ary = $this -> record_to_array($resource_id);
			# If not admin or contributor then hide certain fields by scratching from the array
			if (! ( ($this->ion_auth->is_admin()  || $this->ion_auth->in_group('contributor')) ) ) 
			{
				unset($resource_detail_ary['Notes']);
				unset($resource_detail_ary['Restricted']);
				unset($resource_detail_ary['Visible']);
			}
			if ( ! $resource_detail_ary)
			{
				$data['error'] = "<div class=\"error\" ><p>The resource ID $resource_id is invalid. 
									Try again, buster.</p></div>";
			}
			else
			{
				$data['resource_detail_ary'] = $resource_detail_ary; 
				$data['resource_tags_query'] = $this -> ResourceDB_model -> get_resource_tags($resource_id);
				$data['resource_subjects_query'] = $this -> ResourceDB_model -> get_resource_subjects($resource_id);
			}
		}
		$data['resource_id'] = $resource_id;
		// define some vars to pass to the nav and page views
		$data['title'] = "Global Health: resource detail";
		$data['heading'] = "Resource detail"; 		
		// for <meta> tags and DC
		$data['description'] = "";
		$data['keywords'] = "";
		$data['active_topnav'] = ""; // active menu item
		$data['active_leftnav'] = "Search"; // active menu item
		$data['active_submenu'] = ""; // active menu item
		$data['query'] = $this -> ResourceDB_model -> get_public_resources();	
		$template['content'] = $this -> load -> view('search/record_view', $data, TRUE);
	
		$this -> load -> view('template2_view', $template);
		# Load confirmation script for 'are you sure?' dialogue on delete
		$script_data['text'] = "\"Do you really want to delete this resource? You cannot undo this action.\"";
		$this -> load -> view('confirm_script_view', $script_data);
	}
	
	/**
	* Put user-relevant fields for a resource into an assoc array, for display in a view.
	* This involves a bit of formatting and joining with junction tables
	* @param int $resource_id ID of resource
	* @return mixed | boolean Associative array with user-friendly field names and values, or 
	* false on failure
	*/
	function record_to_array($resource_id)
	{
		$record_ary = array();
		$resource_query = $this -> ResourceDB_model -> get_resource_detail($resource_id);
		# If the query returns no rows then plainly the resource ID is invalid, so return false
		if ($resource_query -> num_rows() == 0)
		{
			return FALSE;
		}
		
		# Full record details passed from controller in $query
		# Go through record, get parent values for foreign keys, then display
		# Strictly speaking, the model methods should be called from the controller, rather 
		# than from this view - FIX THIS BY CREATING THE INFO DISPLAY ARRAY IN THE CONTROLLER!!
		foreach ($resource_query -> row() as $key => $val)
		{
			switch ($key)
			{
				case 'id': 
				{
					# Get resource id to put in comments link
					$record_ary['Resource ID'] = $val;
					break;
				}
				case 'type':
				{
					$qry = $this -> ResourceDB_model -> get_res_type($val);
					$row = $qry -> row();
					$type = $row -> title;
					$record_ary['Resource type'] = $type;
					break;
				}
				
				case 'source':
				{
					$qry = $this -> ResourceDB_model -> get_origin($val);
					$row = $qry -> row();
					$source = $row -> title;
					$record_ary['Source/origin'] = $source; 
					break;
				}
			
				case 'metadata_author':
				{
					if (!empty($val))
					{
						# Check that user ID is in the resourcedb_users table
						# Use ion-auth function to get name of user recorded as metadata editor
						if ($author = $this -> ion_auth -> user($val) ->row())
						{
							$editor = $author -> first_name . " " . $author -> last_name;
							# Make the name into a link to search for all records created by author
							$editor = anchor ("browse/list_titles/editor/" . $author -> id, $editor, 'title="Browse titles edited by this user"');
						}
						else
						{
							$editor = "Not recorded/unknown";
						}
						$record_ary['Record editor'] = $editor;
				}
					break;
				}
				
				case 'metadata_created':
				{
					$date = unix_to_human (mysql_to_unix ($val), FALSE, 'eu');
					$record_ary['Record created'] = $date;
					break;
				}
	
				case 'metadata_modified':
				{
					$date = unix_to_human (mysql_to_unix ($val), FALSE, 'eu');
					$record_ary['Record updated'] = $date;
					break;
				}
				
				case 'url':
				{
					$record_ary['URL'] = "<a href=\"$val\">$val</a>"; 
					break;
				}
				
				case 'visible':
				case 'restricted': 
							
				default:
				{
					# print other fields as is, though capitalise first char of fieldname					
					$record_ary[ucfirst($key)] = $val;
				}
			} // end switch
			
		}// end foreach

		return $record_ary; 
	
	} // end function


}
?>
