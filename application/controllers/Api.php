<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Site_Controller 
{
	private $params = array();
	private $MAX_TRAVEL_TIME = 15; // measured in minutes

	public function __construct()
	{
		parent::__construct();
		
		// if this isn't the api domain, get out of here
		if($_SERVER["HTTP_HOST"] != "api.rx-arven.com")
		{
			redirect("/dashboard");
		}
	}

	public function index()
	{
	}

	public function set_user_location()
	{
		$params = $this->uri->uri_to_assoc(3);
		//NOTE: This would normally send a user id or tracker id 
		// with it in order to update the x/y/z coordinates for the proper tag
		// but given our hardware limitations, we only need x/y/z coordinates
		extract(filter_options(array('x', 'y', 'z'), $params));

		exit;
	}

	public function get_user_location()
	{
		$params = $this->uri->uri_to_assoc(3);
		// NOTE: We aren't currently filtering out any params though 
		// if we were it might be something to do with device id or user id
		// we only aren't filtering because of current hardware limitations (only one user tag, 1 robot)
		extract(filter_options(array(), $params));

		exit;
	}

	public function check_schedule()
	{
		$params = $this->uri->uri_to_assoc(3);
		extract(filter_options(array("device_id"), $params));

		//TODO: get needs to be able to filter where the TIME() portion of the ScheduleDateTime is >= TIME(time_after) 
		// and the TIME() portion of the ScheduleDateTime is <= TIME(time_before)
		// and it needs to be able to ORDER BY the order_by field in the specified order_dir (default to ASC)
		// it ALSO needs to return the UserID of the user this schedule is tied to
		$schedules = $this->schedules_model->get(array(
			"device_id" => $device_id, 
			"order_by" => "ScheduleDateTime",
			"order_dir" => "DESC",
			"time_after" => date('Y-m-d H:i:s'),
			"time_before" => date('Y-m-d H:i:s', date("+ $MAX_TRAVEL_TIME minutes"))
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
				// given hardware limitations, we aren't returning that sicne we only have 1 user tag
				echo 1;//$schedule->UserID;
				exit;
			}
		}

		// no schedules to process
		echo "none";exit;
	}
}
