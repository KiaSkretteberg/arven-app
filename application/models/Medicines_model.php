<?php

// CRUD functionality for the Medicines table
class Medicines_model extends CI_Model
{	
	//READ 
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'user_id', 'limit', "schedule_id"), $options));

		if($id) $this->db->where('MedicineID', $id);
		if($user_id) $this->db->where('UserID', $user_id);

        if($schedule_id)
        {
            $this->db->where("ScheduleID", $schedule_id);
            $this->db->join("Schedules", "Schedules.MedicineID = Medicines.MedicineID");
        }


        if($limit) $this->db->limit($limit);


		$query = $this->db->get('Medicines');

		return $this->helper_functions->return_result($query, $result);
	}

    // CREATE/UPDATE
    function save($options = array(), $result = false)
    {
        //CREATE
        //$query = $this->db->insert('Medicines');

        //UPDATE
        //$query = $this->db->update('Medicines');

		//return $this->helper_functions->return_result($query, $result);
    }

    //DELETE
    function delete($options = array())
    {
        //return $this->db->delete('Medicines');
    }
	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	
}