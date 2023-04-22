<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{		
		if($this->form_validation->run("login"))
		{
			// then redirect to dashboard
			redirect("/dashboard");
		}
	}


	// run by form_validation automatically
	public function verify_login($email)
	{	// sample data for testing  (confirmed to work)
		//'bclemenson0@example.com', 1234
		$password = $this->input->post("password");
		
		// check if the email of the user and the entered password are correct/connected
		$user = $this->users_model->login($email, $password);

		// if user is found, set session for use on other pages
	
		if($user)
		{
			// get and assign data
			$sessiondata = array(
						'UserID'=> $user->UserID, // userID for easier searching
						'Name' => $user->FirstName // first name for display
			);
			// set session
			$this->session->set_userdata($sessiondata);	
			return true;
		}
		// otherwise, dont set session and ask user to re-try
		// REMEMBER
		else
		{
			
			// set error message HERE
			$this->form_validation->set_message("verify_login", "User name or email invalid.");

			
			return false;
		}
	}
}
