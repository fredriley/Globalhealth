<?php

# User registration controller
# Code from tutorial in the CI User Guide, under Helper Reference | Form Helper
class Register extends Controller {
	
	function index()
	{
		# Commented out as now loaded in autoload.php
		//$this->load->helper(array('form', 'url'));
		
		
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this -> load -> model ('Users_model');
		//$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]');
		$this->form_validation->set_rules('username', 'Username', 'callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$data ['heading'] = "User registration";
			$data ['title'] = "User registration";
			$this->load->view('resourcedb/registerview', $data);
		}
		else
		{
			$data ['heading'] = "Registration successful";
			$data ['title'] = "Registration successful";
			$this->load->view('resourcedb/register_success', $data);
		}
	}
	
	function username_check($str)
	{
		$query = $this -> Users_model -> check_username($str);
		if ($query -> num_rows() == 0)
		{
			# Username available
			return TRUE;
		}
		else
		{
			#username taken
			$msg = "<p style=\"color:#FF0000; font-size:larger;\">The username <strong>$str</strong> has been taken - 
				please try another. </p>";
			$this->form_validation->set_message('username_check', 
				$msg);
			return FALSE;
		}
	}
}
?>
