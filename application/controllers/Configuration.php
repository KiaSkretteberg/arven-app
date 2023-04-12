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
		// Replace with grabbing the current user
		$user = $this->users_model->get(array('device' =>  'RX-AR2023-0001'), false);
		// Replace with grabbing the device serial from the user
		$device = $this->devices_model->get(array('serial' => 'RX-AR2023-0001'), false);

		if($this->form_validation->run('configuration')) 
		{
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$timezone = $this->input->post('timezone');
			
			$user = $this->user = $this->users_model->save(array(
				'FirstName' => $first_name, 
				'LastName' => $last_name, 
				'Email' => $email, 
				'DeviceID' => $device->DeviceID, 
				'Timezone' => $timezone
			), $user->UserID, true);

			// set user session
		
			$this->helper_functions->set_session($user->UserID, $user->FirstName);

			
			//TODO: Do we need to prompt for tracker?
			
			
		}

		$this->set_view_data(array(
			'device' => $device,
			'user' => $user,
			'timezones' => $this->timezones
		));
	}

	public function initial()
	{
		$view_data = array(
			'timezones' => $this->timezones,
			'default_timezone' => $this->default_timezone
		);

		if($this->form_validation->run('setup')) 
		{
			$serial = $this->input->post('serial');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$timezone = $this->input->post('timezone');
			$password = $this->input->post('password');

			$device = $this->devices_model->get(array('serial' => $serial), false);

			$password_details = $this->helper_functions->generate_password($password);
			
			$user = $this->user = $this->users_model->save(array(
				'FirstName' => $first_name, 
				'LastName' => $last_name, 
				'PasswordSalt' => $password_details["salt"],
				'PasswordHash' => $password_details["hash"],
				'Email' => $email, 
				'DeviceID' => $device->DeviceID, 
				'Timezone' => $timezone
			), false, true);


			$this->helper_functions->set_session($user->UserID, $user->FirstName);
		

			redirect("/dashboard");
		}

		$this->set_view_data($view_data);
	}



	/********************************************************************** 
	
	Validation (Callback) Functions

	**********************************************************************/

	public function serial_exists($serial)
	{
		$device = $this->devices_model->get(array('serial' => $serial), false);

		if(!$device)
		{
			$this->form_validation->set_message('serial_exists', 'No device found with that serial. Please double check and try again.');
			return false;
		}
		else
		{
			return true;
		}
	}

	public function email_unique($email)
	{
		//Add the ability to exclude current user from uniqueness check on configuration page
		$user = $this->users_model->get(array('device' => $this->input->post("serial"), 'email' => $email), false);

		if($user)
		{
			$this->form_validation->set_message('email_unique', 'Looks like you already have an account. Please sign in instead.');
			return false;
		}
		else
		{
			return true;
		}
	}

	public function password_complexity($password)
	{
		//TODO: Determine password complexity rules
		return true;
	}
}
