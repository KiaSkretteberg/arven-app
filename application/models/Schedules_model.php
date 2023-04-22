<?php

// CRUD functionality for the Schedules table
class Schedules_model extends CI_Model
{	
	//READ 
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'user_id', 'medicine_id', 'day', 'date', 'time', 'prescription_id', 'frequency_id', 'frequency'), $options));
		
		if($id) $this->db->where('SchedueID', $id);
		if($medicine_id) $this->db->where('MedicineID', $medicine_id);
		// if($day) $this->db->where('DAY(DATE(NextDelivery))', $day);
		// if($date) $this->db->where('DATE(NextDelivery)', $date);
		// if($time) $this->db->where('TIME(NextDelivery)', $time);
		if($prescription_id) $this->db->where('PrescriptionID', $prescription_id);
		if($frequency_id) $this->db->where('FrequencyID', $frequency_id);

		if($user_id) 
		{
			$this->db->join('Medicines', 'Medicines.MedicineID = Schedules.MedicineID');

			$this->db->where('UserID', $user_id);

			$this->db->select("MedicineName");
			
		}

		if($frequency) $this->db->where('ScheduleFrequencies.FrequencyName', $frequency);

		$this->db->join('ScheduleFrequencies', 'ScheduleFrequencies.FrequencyID = Schedules.FrequencyID');

		$this->db->select("Schedules.*, ScheduleFrequencies.FrequencyName, ScheduleFrequencies.FrequencyTag as Frequency");

		$query = $this->db->get('Schedules');

		return $this->helper_functions->return_result($query, $result);
	}

    // CREATE/UPDATE
    function save()
    {
        //CREATE
        //$query = $this->db->insert('Schedule');

        //UPDATE
        //$query = $this->db->update('Schedule');

		//return $this->helper_functions->return_result($query, $result);
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