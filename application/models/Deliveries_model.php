<?php

class Deliveries_model extends CI_Model
{	
	function get($options = array(), $result = true) 
	{
		extract(filter_options(array('schedule_id', 'medicine_id', 'limit', 'order_by', 'order_dir' => 'asc'), $options));

		if($schedule_id) $this->db->where('ScheduleID', $schedule_id);

		if($medicine_id) 
		{
			$this->db->where('MedicineID', $medicine_id);

			$this->db->join("Schedules", "Schedules.ScheduleID = DeliveryLogs.ScheduleID");
		}

		if($limit) $this->db->limit($limit);

		if($order_by) $this->db->order_by($order_by, $order_dir);

		$query = $this->db->get('DeliveryLogs');

		return $this->helper_functions->return_result($query, $result);
	}

	function log_delivery($data)
	{
		$this->db->set($data);
        $this->db->insert('DeliveryLogs');
		return $this->helper_functions->return_id();
	}

	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}