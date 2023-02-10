<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('devices_model');
	}

	public function index()
	{
		$devices = $this->devices_model->get_devices(array('serial' => 'RX-AR2023-0001'));

		$this->set_view_data(array(
			'devices' => $devices
		));
	}

	public function initial()
	{
		
	}
}
