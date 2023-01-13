<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('str_replace_last'))
{
	function str_replace_last($needle , $replace , $haystack)
	{
	    if(($pos = strrpos($haystack, $needle)) !== false )
	    {
	        $search_length = strlen($needle);
	        $haystack = substr_replace($haystack, $replace, $pos, $search_length);
	    }
	    return $haystack;
	}
}

if ( ! function_exists('get_string_between'))
{
	function get_string_between($string, $start, $end)
	{
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}
}

if ( ! function_exists('strpos_array'))
{
	function strpos_array($haystack, $needles) 
	{
		if(!is_array($needles)) $needles = array($needles);
		foreach($needles as $needle)
		{
		    if(($pos = strpos($haystack, $needle))!==false) return $pos;
		}
		return false;
	}
}

if ( ! function_exists("pre_var_dump") ) {
	function pre_var_dump($mixed) 
	{
		$items = func_get_args();
		foreach($items as $item)
		{
			echo "<pre>";
			var_dump($item);
			echo "</pre>";
		}
	}
}