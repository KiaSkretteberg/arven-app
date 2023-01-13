<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('arrayToObject'))
{
	function arrayToObject($array) {
    if (!is_array($array)) {
        return $array;
    }
    
    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $name=>$value) {
        	if(!is_numeric($name))//this check is to preserve non-associative arrays
        	{
        		$name = strtolower(trim($name));
	            if (!empty($name)) {
	                $object->$name = arrayToObject($value);
	            }
        	}
        	else
        	{
                //this is a non-associate array so preserve it
        		if(is_object($object)) $object = array(); 
                //continue recursive check for associative arrays
        		$object[] = arrayToObject($value);
        	}
        }
        return $object;
    }
    else {
        return FALSE;
    }
}
}