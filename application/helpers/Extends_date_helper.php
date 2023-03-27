<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('is_current_year'))
{
	function is_current_year($date)
	{
		return $date->format("Y") == (now())->format("Y");
	}
}

if ( ! function_exists('is_current_month'))
{
	function is_current_month($date)
	{
		return is_current_year($date) && 
			   $date->format("m") == (now())->format("m");
	}
}

if ( ! function_exists('is_today'))
{
	function is_today($date)
	{
		return is_current_year($date) && 
			   is_current_month($date) && 
			   $date->format("j") == (now())->format("j");
	}
}

if ( ! function_exists('is_tomorrow'))
{
	function is_tomorrow($date)
	{
		$tomorrow = now()->modify("+ 1 day");

		$day = $tomorrow->format("j");
		$month = $tomorrow->format("m");
		$year = $tomorrow->format("Y");

		return $date->format("Y") == $year &&
			   $date->format("m") == $month && 
			   $date->format("j") == $day;
	}
}