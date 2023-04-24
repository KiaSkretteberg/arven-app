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
			$medicationId = $this->input->post("medicationId");
			
			$html = $this->load->view('schedules/index', array(
				"list" => true,
				"schedules" => $this->model->get(array("medicine_id" => $medicationId)),
				"frequencies" => $this->schedule_frequencies_model->get()
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

	public function edit($url, $id)
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
		$schedule = $this->schedules_model->get(array("id" => $id), false);

		if($id != "new" && !$schedule)
		{
			// bail out, this doesn't exist
			exit;
		}

		$this->set_view_data(array(
			"schedule" => $schedule
		));
		
		$this->set_view_file("save");
	}
}
