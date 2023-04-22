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
		$medications = $this->medicines_model->get_list(array("user_id" => $this->userID, "include_schedules" => true));

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
		$medication = $this->medicines_model->get(array("id" => $id, "include_schedules" => true), false);

		// if this isn't a new one, and there's no medication, redirect out of here
		if($id != "new" && !$medication)
		{
			redirect("/medications");
		}

		if($this->form_validation->run("save_medication"))
		{
			$units = $this->input->post("unit");
			$units_plural = !empty($this->input->post("unit_plural")) ? $this->input->post("unit_plural") :  $units . "s";

			$medication_id = $this->medicines_model->save(array(
				"MedicineName" => $this->input->post("name"),
				"Dose" => $this->input->post("dose"),
				"Unit" => $units,
				"Volume" => $this->input->post("volume"),
				"Low" => $this->input->post("low_threshold"),
				"UserID" => $this->userID,
				"UnitPlural" => $units_plural
			), $id != "new" ? $id : false);

			if($medication_id) 
			{
				redirect("/medications/edit/$medication_id");
			}
			else 
			{
				$this->session->set_flashdata("error", "There was an error, please try again.");
			}
		}

		$latest_delivery = $this->deliveries_model->get(array(
			"order_by" => "DeliveryLogDateTime",  
			"order_dir" => "desc", 
			"medicine_id" => $id), false);
			
		$this->set_view_data(array(
			"medication" => $medication,
			"latest_delivery" => $latest_delivery
		));
		$this->set_view_file("save");
	}
}
