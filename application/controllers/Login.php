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
		$sessiondata = array(
			'UserID'=> null,
			'Name' => null,
			'LoggedIn' => null);
		// set session
		$this->session->set_userdata($sessiondata);
		
	}


	// run on login click
	// 
	private function CheckCredentials($user, $password)
	{	// sample data for testing  (confirmed to work)
		//'bclemenson0@example.com', 1234
		
		// check if the email of the user and the entered password are correct/connected
		$users = $this->users_model->login($user, $password, false);
		
		// store any user ID to use as a check
		$userID = $users->UserID;
		

		// if user is found, set session for use on other oages
		if($userID)
		{
			// get and assign data
			$sessiondata = array(
						'UserID'=> $userID, // userID for easier searching
						'Name' => $users->FirstName // first name for display
			);
			// set session
			$this->session->set_userdata($sessiondata);			

			// then redirect to dashboard
			redirect("/dashboard");
		}
		// otherwise, dont set session and ask user to re-try
		// REMEMBER
		else
		{
			
			// set error message HERE

			
		}
		
		
	}
}
