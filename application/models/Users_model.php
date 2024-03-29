<?php

// CRUD functionality for the Users table
class Users_model extends CI_Model
{	
	//READ
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'device', 'email', "include_device"), $options));

		if($id) $this->db->where('UserID', $id);
		if($email) $this->db->where('Email', $email);

		if($device || $include_device) 
		{
			$this->db->join('Devices', 'Devices.DeviceID = Users.DeviceID');

			if($device) $this->db->where('Devices.SerialNum', $device);
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

    //DELETE??
	// implement if we have time
	// archive?? active state
	//make sure to confirm cascading LUL
    function delete($options = array())
    {
		//extract(filter_options(array('email'), $options));
        //return $this->db->delete('Users');
    }

	// check login
	function login($email, $pass)
	{
		// no user, return error and message
		if($email == null)
		{
			error_log("User_model login. No email entered. ");
			return null;
		}

		// no password, return error and message
		if($pass == null)
		{
			error_log("User_model login. No user entered. ");
			return null;
		}

		$this->db->where('Email', $email);		

		$query = $this->db->get('Users');

		// check if user exists
		$user = $this->helper_functions->return_result($query, false);

		if($user)
		{
			// check if password matches user
			if($this->helper_functions->create_hash($pass, $user->PasswordHash) === $user->PasswordSalt)
			{
				return $user;
			}
		}
		return null;
	}
	


	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}