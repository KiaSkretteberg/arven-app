<?php

// CRUD functionality for the Users table
class Users_model extends CI_Model
{	
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
    function save()
    {
        //CREATE
        //$query = $this->db->insert('Users');

        //UPDATE
        //$query = $this->db->update('Users');

		//return $this->helper_functions->return_result($query, $result);
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