<?php

// CRUD functionality for the Schedules table
class Schedule_frequencies_model extends CI_Model
{	
	//READ 
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'schedule_id', 'frequency'), $options));

		if($id) $this->db->where('FrequencyID', $id);
		if($schedule_id) 
		{
			$this->db->where('Schedule.SchedueID', $schedule_id);

			$this->db->join('Schedule', 'ScheduleFrequency.FrequencyID = Schedule.FrequencyID');
		}
		if($frequency) $this->db->where('FrequencyName', $frequency);

		$this->db->select("ScheduleFrequency.*");

		$query = $this->db->get('ScheduleFrequency');

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