<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->set_view_file("partial/json_encode.php")
	}
}
