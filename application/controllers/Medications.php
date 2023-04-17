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

	private function save($id = "new")
	{
		$medication = $this->medicines_model->get(array("id" => $id), false);
		// TODO: This should be removed once schedules have been added to be pulled as part of the above query
		// TODO: This list of schedules needs to include the FrequencyName for each schedule
		if($medication) $medication->schedules = $this->schedules_model->get();

		//TODO: Set up the form validation rules in the config file
		if($this->form_validation->run("save_medication"))
		{
			//TODO: Add the medication and grab the new id (only)
			$medication_id = 0;
			redirect("/medications/edit/$medication_id");
		}

		$this->set_view_data(array(
			"medication" => $medication
		));
		$this->set_view_file("save");
	}
}
