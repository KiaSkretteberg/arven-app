<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		// if this isn't the api domain, get out of here
		if($_SERVER["HTTP_HOST"] != "api.rx-arven.com")
		{
			redirect("/dashboard");
		}
	}

	public function index()
	{
		var_dump($this->input->get());exit;
		$this->set_view_file("partial/json_encode.php");
	}
}
