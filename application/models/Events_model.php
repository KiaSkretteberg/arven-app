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

	function get($options = array(), $result = true)
	{
		extract(filter_options(array('tag', 'userid', 'limit', 'order', 'maker', 'before', 'after'), $options));

		
		if($userid)
		{
			$this->db->join('Devices', 'Devices.DeviceID = EventLogs.DeviceID');
			$this->db->join('Users', 'Users.DeviceID = Devices.DeviceID');
			$this->db->where('Users.UserID', $userid);
			
		}
		// get types of 
		$this->db->join('EventTypes', 'EventTypes.EventTypeID = EventLogs.EventTypeID');
		//specific events
		if($tag)
		{
			$this->db->where('EventTypes.TypeTag', $tag);
			
		}
		// amount wanted
		if($limit) 
		{
			$this->db->limit($limit);			
		}
		if($maker)
		{
			$this->db->where('EventLogs.EventMaker', $maker);
		}
		if($before)
		{
			$this->db->where('EventLogs.EventDateTime <', $before);
		}
		if($after)
		{
			$this->db->where('EventLogs.EventDateTime >', $after);
		}

		// order of events
		// asc vs desc
		if($order)
		{
			$this->db->order_by('EventLogs.EventDateTime', $order);
		}
		else{
			$this->db->order_by('EventLogs.EventDateTime desc');
		}
		
		$this->db->select("EventLogs.*, EventTypes.*");
		$query = $this->db->get('EventLogs');
		
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