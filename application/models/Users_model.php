<?php

// CRUD functionality for the Users table
class Users_model extends CI_Model
{	
	//READ
	function get($options = array(), $result = true) 
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

    // CREATE/UPDATE
    function save($data, $id = false, $return_user = false)
    {
		$this->db->set($data);
		
		// UPDATE
		if($id !== false)
		{
			$this->db->where('UserID', $id);
			
			$this->db->update('Users');
		}
		//CREATE
		else
		{
			$this->db->insert('Users');
		}

		$user_id = $this->helper_functions->return_id($id);
		
		if(!$return_user || !$user_id)
		{
			return $user_id;
		}
		else
		{
			$options = array('id' => $user_id);

			return $this->get($options, false);
		}
    }

    //DELETE
    function delete()
    {
        //return $this->db->delete('Users');
    }

	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}