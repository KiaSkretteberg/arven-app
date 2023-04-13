<?php

class Events_model extends CI_Model
{	
	function get_types($options = array(), $result = true) 
	{
		extract(filter_options(array('tag'), $options));

		if($tag) $this->db->where('TypeTag', $tag);

		$query = $this->db->get('EventTypes');

		return $this->helper_functions->return_result($query, $result);
	}

	function log_event($data)
	{
		$this->db->set($data);
        $this->db->insert('EventLogs');
		return $this->helper_functions->return_id();
	}

	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}