<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// TODO: we need to pull the EventLogs with most recent first

		// TODO: we need a list of filters that could be applied to EventLogs
	}
}
