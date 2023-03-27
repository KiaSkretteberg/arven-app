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
			"schedules" => $this->schedules_model->get()
		));
	}

	public function add()
	{
		$this->save();
	}

	public function edit($id)
	{
		$this->save($id);
	}

	public function delete()
	{

	}

	private function save($id = null)
	{
		$this->set_view_data(array(
			"schedule" => $this->schedules_model->get(array("id" => $id), false)
		));
		$this->set_view_file("save");
	}
}
