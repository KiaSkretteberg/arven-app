<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
	}
	/**
	 * This is the default controller so "url/" will map to the index function
	 * because of a route defined in the routes.php file, any other slashes will map to their corresponding functions here
	 * i.e. "url/test" maps to "url/index.php/router/test"
	 */
	public function index()
	{
		// Get current logged in user 
		$user =  $this->helper_functions->get_session();

		//If user found, direct to dashboard
		if($user)  
		{
			redirect("/dashboard");
		}
		else
		{
			redirect("/login");
		}

		
	}
}
