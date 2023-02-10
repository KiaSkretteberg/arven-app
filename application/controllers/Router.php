<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * This is the default controller so "url/" will map to the index function
	 * because of a route defined in the routes.php file, any other slashes will map to their corresponding functions here
	 * i.e. "url/test" maps to "url/index.php/router/test"
	 */
	public function index()
	{
		$users = $this->model->get_users(array('device' => 'rx-ar2023-0001'));

		foreach($users as $user)
		{
			$user->schedules = $this->model->get_schedules(array('user_id' => $user->id));

			foreach($user->schedules as $schedule)
			{
				$schedule->date = strtotime($schedule->schedule_datetime);
			}
		}

		$this->set_view_data(array(
			'users' => $users
		));
	}
}
