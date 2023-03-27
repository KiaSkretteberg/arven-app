<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$medications = $this->medicines_model->get(array("user_id" => $this->userID, false));

		$this->set_view_data(array(
			"medications" => $medications
		));
	}
}
