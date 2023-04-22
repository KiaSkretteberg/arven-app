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
		extract(filter_options(array('tag', 'userid', 'limit', 'order_by', 'order_dir' => "asc", 'maker', 'before', 'after', 'exclude', 'include'), $options));
		
		if($userid)
		{
			$this->db->join('Devices', 'Devices.DeviceID = EventLogs.DeviceID');
			$this->db->join('Users', 'Users.DeviceID = Devices.DeviceID');
			$this->db->where('Users.UserID', $userid);
		}

		// get types of 
		$this->db->join('EventTypes', 'EventTypes.EventTypeID = EventLogs.EventTypeID');
		//specific events
		if($tag) $this->db->where('EventTypes.TypeTag', $tag);

		// amount wanted
		if($limit)  $this->db->limit($limit);			
		if($maker) $this->db->where('EventMaker', $maker);
		if($before) $this->db->where('EventDateTime <', $before);
		if($after) $this->db->where('EventDateTime >', $after);

		if($exclude)
		{
			foreach ($exclude as $key => $value) 
			{
				if(is_array($value)) 
				{
					$this->db->where_not_in("$key", $value);
				} 
				else 
				{
					$this->db->where("$key !=", $value);
				}
			}
		}

		if($include)
		{
			foreach ($include as $key => $value) 
			{
				if(is_array($value)) 
				{
					$this->db->where_in("$key", $value);
				} 
				else 
				{
					$this->db->where("$key !=", $value);
				}
			}
		}

		if($order_by) $this->db->order_by($order_by, $order_dir);
		
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