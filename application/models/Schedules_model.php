<?php

// CRUD functionality for the Schedules table
class Schedules_model extends CI_Model
{	
	//READ 
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'user_id', 'medicine_id', 'day', 'date', 'time', 'prescription_id', 'frequency_id', 'frequency', 'include_device_id', 'manual', 'include_once', 'time_after', 'time_before', 'order_by', 'order_dir' => 'asc', 'limit'), $options));
		
		if($id) $this->db->where('ScheduleID', $id);
		if($medicine_id) $this->db->where('Schedules.MedicineID', $medicine_id);
		if($prescription_id) $this->db->where('PrescriptionID', $prescription_id);
		if($frequency_id) $this->db->where('FrequencyID', $frequency_id);

		// if($day) $this->db->where('DAY(DATE(NextDelivery))', $day);
		// if($date) $this->db->where('DATE(NextDelivery)', $date);
		// if($time) $this->db->where('TIME(NextDelivery)', $time);
		if($time_after) $this->db->where("TIME(ScheduleDateTime) >= TIME('$time_after')");
		if($time_before) $this->db->where("TIME(ScheduleDateTime) <= TIME('$time_before')");

		if($user_id) $this->db->where('UserID', $user_id);

		if($manual)
		{
			$this->db->where("Active", 0);
			$this->db->where("ScheduleDateTime", NULL);
		}
		else
		{
			$this->db->where("Active", 1);
		}

		$this->db->join('ScheduleFrequencies', 'ScheduleFrequencies.FrequencyID = Schedules.FrequencyID');

		$this->db->join('Medicines', 'Medicines.MedicineID = Schedules.MedicineID');

		if($include_device_id)
		{
			$this->db->join("Users", "Users.UserID = Medicines.UserID");
			$this->db->select("Users.DeviceID");
		}

		if(!$include_once && !$manual) $this->db->where("ScheduleFrequencies.FrequencyTag !=", "once");

		if($frequency) $this->db->where('ScheduleFrequencies.FrequencyName', $frequency);

		if($order_by) $this->db->order_by($order_by, $order_dir);
		
		if($limit) $this->db->limit($limit);

		$this->db->select(
			"Schedules.*, 
			ScheduleFrequencies.FrequencyName, 
			ScheduleFrequencies.FrequencyTag as Frequency, 
			MedicineName, 
			Medicines.UserID");

		$query = $this->db->get('Schedules');

		return $this->helper_functions->return_result($query, $result);
	}

    // CREATE/UPDATE
    function save($data, $id = false, $return_schedule = false)
    {   
		$this->db->set($data);

        // UPDATE
		if($id !== false)
		{
			$this->db->where('ScheduleID', $id);
			
			$this->db->update('Schedules');
		}
		//CREATE
		else
		{
			$this->db->insert('Schedules');
		}

		$schedule_id = $this->helper_functions->return_id($id);
		
		if(!$return_schedule || !$schedule_id)
		{
			return $schedule_id;
		}
		else
		{
			$options = array('id' => $schedule_id);

			return $this->get($options, false);
		}
    }

    //DELETE
    function delete()
    {
        //return $this->db->delete('Schedule');
    }
	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	
}