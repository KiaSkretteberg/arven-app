<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();

		/*if(!$this->helper_functions->cookie_wrap('kia'))
		{
			echo "no access allowed";exit;
		}*/
	}
	/**
	 * This is the default controller so "url/" will map to the index function
	 * becuase of a route defined in the routes.php file, any other slashes will map to their corresponding functions here
	 * i.e. "url/campaign" maps to "url/index.php/router/campaign"
	 */
	public function index()
	{
	}
}
