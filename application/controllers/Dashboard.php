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
		// TODO: This needs to be limited to pull 3 max
		$medications = $this->medicines_model->get(array(
			"user_id" => $this->userID,
			"limit" => 3
		));

		var_dump($medications);
		// TODO: This needs to be limited to active ones for this user, 3 max
		// TODO: This needs to return the medicine name as well (e.g. schedules_model needs to return MedicineName for this schedule)
		$schedules = $this->schedules_model->get();

		$this->set_view_data(array(
			"medications" => $medications,
			"active_schedules" => $schedules
		));
	}
}
