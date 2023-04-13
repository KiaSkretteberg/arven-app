<?php
class Delivery_logs_model extends CI_Model
{

    function get($options = array(), $result = true) 
	{
        
		extract(filter_options(array('id' ), $options));

        if($id)
        {
           
            $this->db->where('DeliveryID', $id);
        }

        $query = $this->db->get('DeliveryLogs');
        return $this->helper_functions->return_result($query, $result);

	}





}