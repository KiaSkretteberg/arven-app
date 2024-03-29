<?php

// CRUD functionality for the Medicines table
class Medicines_model extends CI_Model
{	
	//READ 
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'user_id', 'limit', 'schedule_id', 'include_schedules', 'table' => 'Medicines'), $options));

		if($id) $this->db->where('MedicineID', $id);
		if($user_id) $this->db->where('UserID', $user_id);

        if($schedule_id)
        {
            $this->db->where("ScheduleID", $schedule_id);
            $this->db->join("Schedules", "Schedules.MedicineID = Medicines.MedicineID");
        }

		$this->db->where("Archived", 0);

        // limit maxes out how many things returned
        if($limit) $this->db->limit($limit);

		$query = $this->db->get($table);

		if($query->num_rows() > 0)
		{
			$results = $query->result();

			foreach($results as $row)
			{
				if($include_schedules) $row->schedules = $this->schedules_model->get(array('medicine_id' => $row->MedicineID));
			}

			return (($result !== true) ? $results[0] : $results);
		}
		
		return false;
	}

    function get_list($options = array())
    {
		$options["table"] = "MedicationList";
		return $this->get($options);
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
    function delete($options = array())
    {
		extract(filter_options(array('id', 'archive'), $options));

		if(!$id) return false;
		
		if($archive)
		{
			$this->save(array("Archived" => 1), $id);
		}
		else
		{
			$this->db->where("MedicineID", $id);
			$this->db->delete("Medicines");
		}
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}

		return false;
    }
	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	
}