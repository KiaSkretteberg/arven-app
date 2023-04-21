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

        // limit maxes out how many things returned
        if($limit) $this->db->limit($limit);


		$query = $this->db->get('Medicines');

		return $this->helper_functions->return_result($query, $result);
	}

    function get_list($options = array())
    {
		extract(filter_options(array('user_id', 'limit'), $options));

        if($limit) $this->db->limit($limit);
		if($user_id) $this->db->where('UserID', $user_id);

        $query = $this->db->get('MedicationList');

		return $this->helper_functions->return_result($query, true);
    }

    // CREATE/UPDATE
    function save($action = "update", $options = array(), $result = false)
    {   

        extract(filter_options(array('id', 'userid', 'name', 'dose', 'unit', 'volume', 'low', 'plural' ), $options));

       
        // THINGS TO ADD / CHANGE
        if($name) $this->db->set('MedicineName', $name);

        if($dose) $this->db->set('Dose', $dose);
      
        if($unit) $this->db->set('Unit', $unit);

        if($volume) $this->db->set('Volume', $volume);

        if($low) $this->db->set('Low', $low);

        if($plural) $this->db->set('UnitPlural', $plural);

        
       
        // intialize to null so if it doesnt work, then clear error
        $query = null;


        //CREATE
        if($action == "create")
       {     // join to userID
            
            $this->db->set('UserID', $userid);
            $this->db->where('UserID', $userid); 
                
             return $this->db->insert('Medicines');

       }

       //UPDATE
        if($action == "update")
       { 
            // join to userID
            if($userid) $this->db->where('UserID', $userid);
            
            if($id) $this->db->where('MedicineID', $id);  
            
            
            return $this->db->update('Medicines');           
       }

       return null;
		
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