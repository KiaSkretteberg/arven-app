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
		$this->set_view_data(array(
			"schedules" => $this->model->get(),
			"frequencies" => $this->schedule_frequencies_model->get()
		));
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
