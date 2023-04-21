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
			
			// TODO: Filter the schedules based on medicationId
			$html = $this->load->view('schedules/index', array(
				"list" => true,
				"schedules" => $this->model->get(),
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

	public function edit($id)
	{
		if($this->input->post('method') == 'ajax')
		{
			$this->save($id);
		}
		else
		{
			
		}
	}

	public function delete()
	{
		if($this->input->post('method') == 'ajax')
		{
		}
	}

	private function save($id = null)
	{
		$this->set_view_data(array(
			"schedule" => $this->schedules_model->get(array("id" => $id), false)
		));
		$this->set_view_file("save");
	}
}
