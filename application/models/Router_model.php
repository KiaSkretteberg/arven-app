<?php

class Router_model extends CI_Model
{	
	function get_sample($options = array(), $result = true) 
	{
		extract(filter_options(array('id', 'column', 'filter'), $options));

		if($id) $this->db->where('id', $id);

		if($column) $this->db->where('column', $column);

		if($filter) 
		{
			$this->db->join('table', 'table.id = sample.table_id');

			$this->db->where('table.filter', $filter);
		}

		$query = $this->db->get('sample');

		return $this->helper_functions->return_result($query, $result);
	}

	/********************************************************************** 
	
	Helper/Private Functions

	**********************************************************************/ 
	

}