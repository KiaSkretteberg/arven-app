<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();

		//TODO: Determine if using a library to detect current user
		//$this->ci->load->library('users');
	}
	/**
	 * This is the default controller so "url/" will map to the index function
	 * because of a route defined in the routes.php file, any other slashes will map to their corresponding functions here
	 * i.e. "url/test" maps to "url/index.php/router/test"
	 */
	public function index()
	{
		// TODO: Get current logged in user (the below is a suggestion)
		//$users = $this->users->get_current_user();

		// TODO: If user found, direct to dashboard
		redirect("/dashboard");

		// TODO: If no user found, direct to
		//redirect("/login");
	}
}
