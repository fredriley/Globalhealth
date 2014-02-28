<?php
class Suggest extends CI_Controller {

	# Constructor. Not needed in this case, included for show. 
	# Note that if you have a constructor you need to explicitly call its
	# parent to inherit its methods and properties, otherwise they'll be locally overridden
	function Suggest()
	{
		parent::__construct();
		# Enable scaffolding for basic entry into resource table
		//$this -> load -> scaffolding('RESOURCE');
		# Load date helper classes	
		$this -> load -> helper('date');
		# Load email library
		$this->load->library('email');
		$this->load->model('ResourceDB_model');
		$this->load->library('form_validation');
		# Set the delimiters in which the error appears. 
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}

	
	function index()
	{
		$data['title'] = 'Resource DB: suggest resource';
        $data['heading'] = 'Resource DB: suggest resource';
		$this->load->view('resourcedb/suggestview', $data);
	}
	
	
	/**
	* Submit a suggestion by email to the admin
	* Sends an email with details of the suggestion form, plus user details 
	* and sending IP, to the address specified in $email below. 
	*/
	function submit()
	{
		# Validate form input
		$this->form_validation->set_rules('title', 'Resource title', 'required|xss_clean');
		$this->form_validation->set_rules('url', 'Resource URL', 'required|xss_clean|prep_url');
		$this->form_validation->set_rules('description', 'Resource description', 'required|xss_clean');
		
		# If the form doesn't validate, return user to it and populate fields 
		# with user values to save her retyping
		if ($this->form_validation->run() == false)
		{
			$data['heading'] = 'Suggest a resource';
			$this -> load -> view('resourcedb/suggestview', $data);
		}
		# If the form validates ok, get on with it
		if ($this->form_validation->run() == true) 
		{		
			# Use ion_auth function to get details of logged-in user
			$user_id = $_POST['user_id'];
			$user = $this -> ion_auth -> get_user();
			$user_email = $user -> email;
			$user_name = $user -> first_name . " " . $user -> last_name;
			
			# Set email config - this could be placed in a config file - 
			# see the Email class docs
			$config['protocol'] = 'smtp';
			//$config['mailpath'] = '/usr/sbin/sendmail';
			# sendmail path on PC USB stick
			//$config['mailpath'] = "K:\xampp\sendmail";
			# sendmail path on granby
			$config['mailpath'] = '/opt/csw/sbin/exim -t';
			$config['smtp_host'] = 'smtp.nottingham.ac.uk'; 
			$config['smtp_port'] = 25; 
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			# Get form details
			$title = $_POST['title'];
			$url = $_POST['url'];
			$description = $_POST['description'];
			$tags = $_POST['tags'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$message = "Title: $title\n\n
						URL: $url\n\n
						Description: $description\n\n
						Tags: $tags\n\n
						User: $user_name\n\n
						User ID: $user_id\n\n
						IP: $ip\n\n
			";
			
			# Get user details to put in an email
			$email = 'fred.riley@nottingham.ac.uk';
			echo $email;
			$this->email->from($user_email, $user_name);
			$this->email->to($email);
			$this->email->subject('Resource suggestion: ' . $title);
			$this->email->message($message);
			
			# If the email's not been sent alert user
			if (!$this->email->send())
			{
					
				$data['title'] = "Email problem";
				$data['heading'] = "Email problem";
				$data['message'] = "Sorry, there was a problem emailing your suggestion to the 
							database administrator. If you still want to forward your suggestion, 
							please email details to <a href=\"mailto:$email\">$email</a>. ";
				$this -> load -> view('resourcedb/emailview', $data);
				
			}
			else
			{
				
				$data['title'] = "Suggestion sent";
				$data['heading'] = "Suggestion sent";
				$data['message'] = "Thanks for suggesting your site, which we'll have a good old 
							neb at and consider for inclusion in the database. We'll get back to you 
							on it, but if you want some feedback in the meantime  
							please email details to <a href=\"mailto:$email\">$email</a>. ";
				$this -> load -> view('resourcedb/emailview', $data);
	
			}
		} // end if validates
	}
}
?>
