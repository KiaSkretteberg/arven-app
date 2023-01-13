<?php

function filter_options($parameters, $options, $default = false)
{	
	$output = array();
		
	foreach($parameters as $key => $value)
	{
		if(is_numeric($key))
		{
			$output[$value] = ((!isset($options[$value]) || is_null($options[$value])) ? $default : $options[$value]);
		}
		else
		{
			$output[$key] = ((!isset($options[$key]) || is_null($options[$key])) ? $value : $options[$key]);
		}
	}
	
	return $output;
}