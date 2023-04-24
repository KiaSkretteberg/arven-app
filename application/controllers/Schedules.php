<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->post('method') == 'ajax')
		{
			$medication_id = $this->input->post("medication_id");
			
			$html = $this->load->view('schedules/index', array(
				"list" => true,
				"schedules" => $this->model->get(array("medicine_id" => $medication_id)),
				"frequencies" => $this->schedule_frequencies_model->get(),
				"medication_id" => $medication_id
			), true);

			$this->set_view_data('data', $html);

			$this->set_view_file('partial/json_encode');
		}
		// if this wasn't an ajax request, get out of here
		else
		{
			redirect("/");
		}
	}

	public function add()
	{
		if($this->input->post('method') == 'ajax')
		{
			$this->save();
		}
	}

	public function edit($url, $id = null)
	{
		if($this->input->post('method') == 'ajax')
		{
			$this->save($id);
		}
	}

	public function delete()
	{
		if($this->input->post('method') == 'ajax')
		{
		}
	}

	private function save($id = "new")
	{
		if($this->input->post("method") == "ajax")
		{
			$id = $this->input->post("id");
			$medication_id = $this->input->post("medication_id");

			$schedule = $this->schedules_model->get(array("id" => $id, 'medicine_id' => $medication_id), false);

			if($id != "new" && !$schedule)
			{
				// bail out, this doesn't exist
				exit;
			}

			if($this->form_validation->run("save_frequency"))
			{
				$frequency = $this->input->post("frequency");
				$date = $this->input->post("date");
				$time = $this->input->post("time");

				$datevalues = explode("-", $date);
				$timevalues = explode(":", $time);

				// create a new datetime to represent the values provided
				$datetime = new DateTime();
				// ensure the datetime is in our timezone
				$datetime->setTimeZone(new DateTimeZone("America/Edmonton"));
				// set the date and time that were provided
				$datetime->setDate($datevalues[0], $datevalues[1], $datevalues[2]);
				$datetime->setTime($timevalues[0], $timevalues[1]);
				// switch the timezone back to utc so it can be saved to databsse properly
				$datetime->setTimeZone(new DateTimeZone("UTC"));

				$id = $this->schedules_model->save(array(
					"MedicineID" => $medication_id,
					"FrequencyID" => $frequency,
					"ScheduleDateTime" => $datetime->format("Y-m-d H:i:s"),
					"Active" => 1
				), $id != "new" ? $id : false, false);
			}

			echo $id;
			exit;
		}
	}
}
