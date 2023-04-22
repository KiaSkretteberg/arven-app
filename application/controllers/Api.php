<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Site_Controller 
{
	private $params = array();
	private $device;
	private $MAX_TRAVEL_TIME = 15; // measured in minutes

	public function __construct()
	{
		parent::__construct();
		
		// if this isn't the api domain, get out of here
		if($_SERVER["HTTP_HOST"] != "api.rx-arven.com")
		{
			redirect("/dashboard");
		}

		$this->params = $this->uri->uri_to_assoc(3);
		
		extract(filter_options(array('device'), $this->params));

		if($device) $this->device = $this->devices_model->get(array("serial" => $device), false);
	}

	public function index()
	{
	}

	// expect url format: "set_user_location/x/######/y/######/z/######"
	public function set_user_location()
	{
		//NOTE: This would normally send a user id or tracker id 
		// with it in order to update the x/y/z coordinates for the proper tag
		// but given our hardware limitations, we only need x/y/z coordinates
		extract(filter_options(array("x", "y", "z"), $this->params));

		$user_id = 22; // hardcoded for ease of testing to the "User" user

		$this->users_model->save(array("TrackerPosition" => json_encode(array("x" => $x, "y" => $y, "z" => $z))), $user_id);
	}

	// expect url format: "get_user_location"
	public function get_user_location()
	{
		// NOTE: We aren't currently filtering out any params though 
		// if we were it might be something to do with device id or user id
		// we only aren't filtering because of current hardware limitations (only one user tag, 1 robot)
		extract(filter_options(array(), $this->params));

		$user_id = 22; // hardcoded for ease of testing to the "User" user

		$user = $this->users_model->get(array("id" => $user_id), false);

		$position = json_decode($user->TrackerPosition);
		echo "x:".$position->x.";y:".$position->y.";z:".$position->z.";";
	}

	// expect url format: "check_schedule/device/RX-AR2023-####"
	public function check_schedule()
	{
		extract(filter_options(array(), $this->params));

		$start_date = new DateTime("- 30 seconds"); // give 30 second leeway for one time deliveries
		$end_date = new DateTime("+ $this->MAX_TRAVEL_TIME minutes");

		$schedules = $this->schedules_model->get(array(
			"device" => $this->device->DeviceID, 
			"order_by" => "ScheduleDateTime",
			"order_dir" => "DESC",
			"include_once" =>  true,
			"time_after" => $start_date->format('Y-m-d H:i:s'),
			"time_before" => $end_date->format('Y-m-d H:i:s')
		));

		foreach($schedules as $schedule)
		{
			$next_schedule = determine_next_delivery(new DateTime($schedule->ScheduleDateTime), $schedule->Frequency);
			
			// the next schedule is today, so it's relevant, we want to process the first schedule we find
			if(strpos($next_schedule, "today") !== false)
			{
				// NOTE: This would ideally return the tracker id, user id, something that would
				// uniquely identify which tag is associated with this schedule, so that future requests
				// to check position would be able to specify which tag to look for
				// given hardware limitations, we aren't returning that since we only have 1 user tag
				echo "UserID:".$schedule->UserID.";ScheduleID:".$schedule->ScheduleID.";";
				exit;
			}
		}

		// no schedules to process
		echo "none";exit;
	}

	public function retrieve_dose_stats()
	{
		extract(filter_options(array("schedule_id"), $this->params));

		$medicine = $this->medicines_model->get(array("schedule_id" => $schedule_id), false);

		echo $medicine->Volume;exit;
	}

	public function log_delivery()
	{
		extract(filter_options(array("schedule_id"), $this->params));

		$medicine = $this->medicines_model->get(array("schedule_id" => $schedule_id), false);

		$this->deliveries_model->log_delivery(array(
			"ScheduleID" => $schedule_id,
			"Automated" => true,
			"DoseGiven" => $medicine->Dose
		));
	}

	public function log_missing_user()
	{
		extract(filter_options(array("schedule_id"), $this->params));

		$schedule = $this->schedules_model->get(array("id" => $schedule_id, "include_device_id" => true), false);
		$event_type = $this->events_model->get_types(array("tag" => "system_err"), false);
		$schedule_time = determine_delivery_stamp(new DateTime($schedule->ScheduleDateTime));

		$this->events_model->log_event(array(
			"DeviceID" => $schedule->DeviceID,
			"EventName" => "User Not Found",
			"EventTypeID" => $event_type->EventTypeID,
			"EventDescription" => $schedule->MedicineName . " was not delivered " . str_replace("Daily: ", "@ ", $schedule_time).".",
			"EventMaker" => "Arven",
			"EventIcon" => "user-slash"
		));
	}

	public function log_event()
	{
		extract(filter_options(array("event_type", "event_name", "event_description", "source"), $this->params));

		$event = $this->events_model->get_types(array("tag" => $event_type), false);

		$this->events_model->log_event(array(
			"DeviceID" => $this->device->DeviceID,
			"EventName" => urldecode($event_name),
			"EventTypeId" => $event->EventTypeID,
			"EventMaker" => $source,
			"EventDescription" => urldecode($event_description)
		));
	}

	// TODO (Kia): function to receive "battery low" event from robot
	
}
