<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('determine_next_delivery'))
{
    function determine_next_delivery($date, $frequency, $timezone = "America/Edmonton") 
    {
        $timezone = new DateTimeZone($timezone);
        // create a copy of the original date for use later
        $originalDate = clone $date;
        // grab an instance of today
        $today = new DateTime();
        $originalDate->setTimeZone($timezone);
        $date->setTimeZone($timezone);
        $today->setTimeZone($timezone);
        // the time has already passed
        $time_past = $date->format("H") <= $today->format("H") &&  $date->format("i") <= $today->format("i");
        // the time is some point in the future
        $time_future = $date->format("H") > $today->format("H") || ($date->format("H") == $today->format("H") && $date->format("i") > $today->format("i"));

        switch($frequency)
        {
            case "daily":
                // if the time has already passed, next will be tomorrow
                if($time_past)
                {
                    $date = new DateTime("+ 1 day");
                    $date->setTimeZone($timezone);
                }
                // if the time hasn't passed, next will be today
                else
                    $date = $today;
                break;
            case "weekly":
                // if it's the same day of the week
                if($date->format("N") == $today->format("N")) 
                {
                    // if the time already passed, next will be next week
                    if($time_past)
                    {
                        $date = new DateTime("+ 1 week");
                        $date->setTimeZone($timezone);
                    }
                    // if the time hasn't passed, next will be today
                    else
                        $date = $today;
                }
                // if the event is later in the week
                elseif($date->format("N") > $today->format("N")) 
                {
                    $date = new DateTime($date->format("l"));
                    $date->setTimeZone($timezone);
                }
                // if the event was earlier in the week
                else  
                {
                    $date = new DateTime("next ".$date->format("l"));
                    $date->setTimeZone($timezone);
                }
                break;
            case "monthly":
                // if it's the same day of the month
                if($date->format("j") == $today->format("j")) 
                {
                    // if the time already passed, next will be next month
                    if($time_past)
                    {
                        $date = new DateTime("+ 1 month");
                        $date->setTimeZone($timezone);
                    }
                    // if the time hasn't passed, next will be today
                    else
                        $date = $today;
                }
                // if the event is not today
                else 
                {
                    // keep today for now, we'll shift the date after
                    $date = clone $today;
                    // keep today's month/year, take the date's "day" value
                    $date->setDate($today->format("Y"), $today->format("m"), $originalDate->format("j"));
                    
                    // if the event was earlier in the month, move to the next month
                    if($date->format("j") < $today->format("j")) 
                    {
                        $date = $date->modify("next month");
                    }
                }
                break;
            case "annually":
                // if it's the same month and day of the year
                if($date->format("m") == $today->format("m") && $date->format("j") == $today->format("j")) 
                {
                    // if the time already passed, next will be next yyear
                    if($time_past)
                    {
                        $date = new DateTime("+ 1 year");
                        $date->setTimeZone($timezone);
                    }
                    // if the time hasn't passed, next will be today
                    else
                        $date = $today;
                    
                    $date->setTimeZone($timezone);
                }
                // if the event is not today
                else 
                {
                    // keep the date's month and day value, take today's year
                    $date->setDate($today->format("Y"), $date->format("m"), $date->format("j"));
                    
                    // if the event was earlier in the year, move to the next year
                    if($date->format("m") < $today->format("m") || $date->format("j") < $today->format("j")) 
                    {
                        $date = $date->modify("next year");
                    }
                }
                break;
        }

        // ensure the time is correct on the date
        $date->setTime($originalDate->format("H"), $originalDate->format("i"));

        // populte the schedule text with the time first
        $schedule = $date->format("g:ia ");

        $is_today = is_today($date);
        $is_tomorrow = is_tomorrow($date);

        if($is_today) 
        {
            $schedule .= "today";
        }
        elseif($is_tomorrow) 
        {
            $schedule .= "tomorrow";
        }
        elseif(!$is_today && !$is_tomorrow)
        {
            // add the date in the format "Mon, Jun 10th"
            $schedule .= $date->format("D, M jS");
        }
        return $schedule;
    }
}