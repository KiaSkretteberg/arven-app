<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('is_current_year'))
{
	function is_current_year($date)
	{
		$today = new DateTime();
		return $date->format("Y") == $today->format("Y");
	}
}

if ( ! function_exists('is_current_month'))
{
	function is_current_month($date)
	{
		$today = new DateTime();
		return is_current_year($date) && 
			   $date->format("m") == $today->format("m");
	}
}

if ( ! function_exists('is_today'))
{
	function is_today($date)
	{
		$today = new DateTime();
		return is_current_year($date) && 
			   is_current_month($date) && 
			   $date->format("j") == $today->format("j");
	}
}

if ( ! function_exists('is_tomorrow'))
{
	function is_tomorrow($date)
	{
		$tomorrow = new DateTime("+ 1 day");

		$day = $tomorrow->format("j");
		$month = $tomorrow->format("m");
		$year = $tomorrow->format("Y");

		return $date->format("Y") == $year &&
			   $date->format("m") == $month && 
			   $date->format("j") == $day;
	}
}