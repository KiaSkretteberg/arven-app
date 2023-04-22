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

	public function edit($url, $id = false)
	{
		$this->save($id);
	}

	public function delete($url, $id = false)
	{
		if($this->medicines_model->delete(array("id" => $id, "archive" => true)))
		{
			$this->session->set_flashdata("success", "Medication deleted successfully.");
		}

		redirect("/medications");
	}

	public function log_dose($url, $id = false)
	{
		if($id)
		{
			$medication = $this->medicines_model->get(array("id" => $id), false);
			
			if($medication)
			{
				$schedule = $this->schedules_model->get(array("manual" => true, "medicine_id" => $id), false);

				$this->deliveries_model->log_delivery(array(
					"ScheduleID" => $schedule->ScheduleID,
					"Automated" => false,
					"DoseGiven" => $medication->Dose
				));
			}
		}
		redirect("/medications");
	}

	public function request_delivery($url, $id = false)
	{
		if($id)
		{
			$medication = $this->medicines_model->get(array("id" => $id), false);
			
			if($medication)
			{
				$schedule_frequency = $this->schedule_frequencies_model->get(array("frequency" => "once"), false);
				$date = new DateTime();

				$schedule_id = $this->schedules_model->save(array(
					"MedicineId" => $id,
					"FrequencyID" => $schedule_frequency->FrequencyID,
					"Active" => 1,
					"ScheduleDateTime" => $date->format("Y-m-d H:i:s")
				));

				if($schedule_id) $this->session->set_flashdata("success", "Delivery requested. Please allow up to 15 minutes for delivery.");
			}
		}
		redirect("/medications");
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
				$schedule_frequency = $this->schedule_frequencies_model->get(array("frequency" => "once"), false);

				// Add a default schedule that can be used for manual dose logging
				$this->schedules_model->save(array(
					"MedicineId" => $medication_id,
					"FrequencyID" => $schedule_frequency->FrequencyID,
					"Active" => 0
				));

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
