<?php

# User registration controller
# Uses ion_auth system - see:
# http://benedmunds.com/ion_auth/
# NB: this is a separate controller from auth.php so as to keep a clear
# distinction between ion_auth functions and custom-written functions

class Register extends CI_Controller 
{

	function Register()
	{
		parent::__construct();
		$this -> load -> helper('form'); 
		$this->load->library('form_validation');


	}
	
	function index()
	{
	
		# Get the submitted details and try to register the user
		# This is a modified version of the create_user() method in auth.php, the main 
		# change being to remove the 'admin user' check so that anyone can self-register.
		
		$this->data['title'] = "Register";
			  
		# Set rules for form input validation
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('phone1', 'First Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
		$this->form_validation->set_rules('phone2', 'Second Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
		$this->form_validation->set_rules('phone3', 'Third Part of Phone', 'required|xss_clean|min_length[4]|max_length[4]');
		$this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

		# If the form validates ok, shove the field contents into variables and try to register the user
		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = $this->input->post('email');
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone1') . '-' . $this->input->post('phone2') . '-' . $this->input->post('phone3'),
			);
		}
		
		# Register the user in the user table. If ok, tell the user then take them
		# to a registration success page; if not ok, regenerate the registration form with the data
		# already entered to save retyping
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone1'] = array(
				'name'  => 'phone1',
				'id'    => 'phone1',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone1'),
			);
			$this->data['phone2'] = array(
				'name'  => 'phone2',
				'id'    => 'phone2',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone2'),
			);
			$this->data['phone3'] = array(
				'name'  => 'phone3',
				'id'    => 'phone3',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone3'),
			);
			$this->data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->_render_page('auth/create_user', $this->data);
		}
	}
		
				
/*	if ($this->form_validation->run() == FALSE)
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
*/
}
	
	
?>
