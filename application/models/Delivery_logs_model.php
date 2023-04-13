<?php
class Delivery_logs_model extends CI_Model
{

    function get($options = array(), $result = true) 
	{
        
		extract(filter_options(array('id', 'userid' ), $options));

        if($userid)
        {
            $this->db->join('Schedules', 'Schedules.ScheduleID = DeliveryLogs.DeviceID');
            $this->db->join('Medicines', 'Schedules.MedicineID = Medicines.MedicineID');
            $this->db->join('Users', 'Users.UserID = Medicines.UserID');
            $this->db->where('Users.UserID', $userid);
        }

        $query = $this->db->get('DeliveryLogs');
        return $this->helper_functions->return_result($query, $result);

	}





}