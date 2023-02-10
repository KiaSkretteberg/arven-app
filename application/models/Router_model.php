<?php

class Router_model extends CI_Model
{	
	function get_schedules($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'user_id', 'day', 'date', 'time', 'prescription_id', 'frequency_id', 'frequency'), $options));

		if($id) $this->db->where('SchedueID', $id);
		// if($day) $this->db->where('DAY(DATE(NextDelivery))', $day);
		// if($date) $this->db->where('DATE(NextDelivery)', $date);
		// if($time) $this->db->where('TIME(NextDelivery)', $time);
		if($prescription_id) $this->db->where('PrescriptionID', $prescription_id);
		if($frequency_id) $this->db->where('FrequencyID', $frequency_id);

		if($user_id) 
		{
			$this->db->join('Medicine', 'Medicine.MedicineID = Schedule.PrescriptionID');

			$this->db->where('UserID', $user_id);
		}

		if($frequency) $this->db->where('ScheduleFrequency.FrequencyName', $frequency);

		$this->db->join('ScheduleFrequency', 'ScheduleFrequency.FrequencyID = Schedule.FrequencyID');

		$this->db->select("Schedule.*, ScheduleFrequency.FrequencyName as frequency");

		$query = $this->db->get('Schedule');

		return $this->helper_functions->return_result($query, $result);
	}

	function get_users($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'device', 'email'), $options));

		if($id) $this->db->where('UserID', $id);
		if($email) $this->db->where('Email', $email);

		if($device) 
		{
			$this->db->join('Devices', 'Devices.DeviceID = Users.DeviceID');

			$this->db->where('Devices.SerialNum', $device);
		}

		$query = $this->db->get('Users');

		return $this->helper_functions->return_result($query, $result);
	}

	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}