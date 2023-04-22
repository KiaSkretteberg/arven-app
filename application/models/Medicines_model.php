<?php

// CRUD functionality for the Medicines table
class Medicines_model extends CI_Model
{	
	//READ 
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'user_id', 'limit', 'schedule_id', 'include_schedules'), $options));

		if($id) $this->db->where('MedicineID', $id);
		if($user_id) $this->db->where('UserID', $user_id);

        if($schedule_id)
        {
            $this->db->where("ScheduleID", $schedule_id);
            $this->db->join("Schedules", "Schedules.MedicineID = Medicines.MedicineID");
        }

        // limit maxes out how many things returned
        if($limit) $this->db->limit($limit);

		$query = $this->db->get('Medicines');

		if($query->num_rows() > 0)
		{
			$results = $query->result();

			foreach($results as $row)
			{
				if($include_schedules) $row->skills = $this->schedules_model->get(array('medicine_id' => $row->id));
			}

			return (($result !== true) ? $results[0] : $results);
		}
		
		return false;
	}

    function get_list($options = array())
    {
		extract(filter_options(array('user_id', 'limit', 'schedule_id', 'include_schedules'), $options));

        if($limit) $this->db->limit($limit);
		if($user_id) $this->db->where('UserID', $user_id);
        
        if($schedule_id)
        {
            $this->db->where("ScheduleID", $schedule_id);
            $this->db->join("Schedules", "Schedules.MedicineID = Medicines.MedicineID");
        }

        $query = $this->db->get('MedicationList');

		if($query->num_rows() > 0)
		{
			$results = $query->result();

			foreach($results as $row)
			{
				if($include_schedules) $row->skills = $this->schedules_model->get(array('medicine_id' => $row->id));
			}

			return (($result !== true) ? $results[0] : $results);
		}
    }

    // CREATE/UPDATE
    function save($data, $id = false, $return_medication = false)
    {   
		$this->db->set($data);

        // UPDATE
		if($id !== false)
		{
			$this->db->where('MedicineId', $id);
			
			$this->db->update('Medicines');
		}
		//CREATE
		else
		{
			$this->db->insert('Medicines');
		}

		$medicine_id = $this->helper_functions->return_id($id);
		
		if(!$return_medication || !$medicine_id)
		{
			return $medicine_id;
		}
		else
		{
			$options = array('id' => $medicine_id);

			return $this->get($options, false);
		}
    }

    //DELETE
    // TODO - not doing yet
    function delete($options = array())
    {
        //return $this->db->delete('Medicines');
    }
	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	
}