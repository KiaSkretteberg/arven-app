<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medication extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// TODO: This needs to pull schedules associated with medications
		$medications = $this->medicines_model->get(array("user_id" => $this->userID));
		// TODO: This should be removed once schedules have been added to be pulled as part of the above query
		$medications[0]->schedules = $this->schedules_model->get();

		$this->set_view_data(array(
			'medications' => $medications
		));
	}
}
