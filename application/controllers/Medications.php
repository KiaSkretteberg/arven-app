<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medications extends Site_Controller 
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

	public function add()
	{
		$this->save();
	}

	public function edit($url, $id)
	{
		$this->save($id);
	}

	public function delete()
	{
	}

	private function save($id = null)
	{
		$this->set_view_data(array(
			"medication" => $id ? $this->medicines_model->get(array("id" => $id), false) : null
		));
		$this->set_view_file("save");
	}
}
