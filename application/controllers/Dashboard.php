<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$medications = $this->medicines_model->get_list(array(
			"user_id" => $this->userID,
			"limit" => 3
		));		
		
		//  This needs to return the medicine name as well (e.g. schedules_model needs to return MedicineName for this schedule)
		$schedules = $this->schedules_model->get(array(
			"active"=> 1,
			"user_id" => 1,
			"limit" => 3
		));

		$alerts = $this->events_model->get(array(
			"limit" => 2,
			"order_by" => "EventDateTime",
			"order_dir" => "desc",
			"include" => array("EventTypes.TypeTag" => array("system_err"))
		));

		$location = $this->events_model->get(array(
			'userid'=> $this->session->UserID,
			"tag" => "robot_navigation",
			"order_by" => "EventDateTime",
			"order_dir" => "desc"
		), false);
		$battery = $this->events_model->get(array(
			'userid'=> $this->session->UserID,
			"tag" => "robot_battery",
			"order_by" => "EventDateTime",
			"order_dir" => "desc"
		), false);
		$connection = $this->events_model->get(array(
			'userid'=> $this->session->UserID,
			"tag" => "robot_connection",
			"order_by" => "EventDateTime",
			"order_dir" => "desc"
		), false);
		
		$this->set_view_data(array(			
			"medications" => $medications,
			"alerts" => $alerts,
			"active_schedules" => $schedules,
			"location" => $location,
			"battery" => $battery,
			"connection" => $connection
		));
	}
}
