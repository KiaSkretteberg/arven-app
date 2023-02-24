<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends Site_Controller 
{
	private $timezones;
	private $default_timezone = "America/Edmonton";

	public function __construct()
	{
		parent::__construct();
		$this->timezones = DateTimeZone::listIdentifiers();
	}

	public function index()
	{
		//TODO: Replace with grabbing the current user
		$user = $this->users_model->get(array('device' =>  'RX-AR2023-0001'), false);
		//TODO: Replace with grabbing the device serial from the user
		$device = $this->devices_model->get(array('serial' => 'RX-AR2023-0001'), false);

		$this->set_view_data(array(
			'device' => $device,
			'user' => $user,
			'timezones' => $this->timezones
		));
	}

	public function initial()
	{
		$this->set_view_data(array(
			'timezones' => $this->timezones,
			'default_timezone' => $this->default_timezone
		));
	}
}
