<?php

class Router_model extends CI_Model
{	
	function get_schedules($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'user_id', 'day', 'date', 'time', 'prescription_id', 'frequency_id', 'frequency'), $options));

		if($id) $this->db->where('id', $id);
		if($day) $this->db->where('DAY(DATE(schedule_datetime))', $day);
		if($date) $this->db->where('DATE(schedule_datetime)', $date);
		if($time) $this->db->where('TIME(schedule_datetime)', $time);
		if($prescription_id) $this->db->where('prescription_id', $prescription_id);
		if($frequency_id) $this->db->where('frequency_id', $frequency_id);

		if($user_id) 
		{
			$this->db->join('prescriptions', 'prescriptions.id = schedules.prescription_id');

			$this->db->where('user_id', $user_id);
		}

		if($frequency) $this->db->where('schedule_frequencies.value', $frequency);

		$this->db->join('schedule_frequencies', 'schedule_frequencies.id = schedules.frequency_id');

		$this->db->select("schedules.*, schedule_frequencies.label as frequency");

		$query = $this->db->get('schedules');

		return $this->helper_functions->return_result($query, $result);
	}

	function get_users($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'device', 'email'), $options));

		if($id) $this->db->where('id', $id);
		if($email) $this->db->where('email', $email);

		if($device) 
		{
			$this->db->join('devices', 'devices.id = users.device_id');

			$this->db->where('devices.serial', $device);
		}

		$query = $this->db->get('users');

		return $this->helper_functions->return_result($query, $result);
	}

	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}