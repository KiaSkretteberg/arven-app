<?php

class Devices_model extends CI_Model
{	
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'serial', 'user_id'), $options));

		if($id) $this->db->where('DeviceID', $id);
		if($serial) $this->db->where('SerialNum', $serial);
		if($user_id)
		{
			$this->db->join("Users", "Users.DeviceID = Devices.DeviceID");
			$this->db->where("UserID", $user_id);
		}

		$query = $this->db->get('Devices');

		return $this->helper_functions->return_result($query, $result);
	}

	function reboot()
	{
		$device = $this->get(array("user_id" => $this->session->UserID), false);

		$this->db->set("Stuck", 0);
		$this->db->where("DeviceID", $device->DeviceID);
		$this->db->update("Devices");
	}

	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}