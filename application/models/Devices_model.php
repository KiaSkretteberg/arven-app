<?php

class Devices_model extends CI_Model
{	
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'serial'), $options));

		if($id) $this->db->where('DeviceID', $id);
		if($serial) $this->db->where('SerialNum', $serial);

		$query = $this->db->get('Devices');

		return $this->helper_functions->return_result($query, $result);
	}

	function save()
	{
		//CREATE
        //$query = $this->db->insert('Devices');

        //UPDATE
        //$query = $this->db->update('Devices');

		//return $this->helper_functions->return_result($query, $result);
	}

	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}