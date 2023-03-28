<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');

// TODO: This should be put in a library or something
function determine_schedule($date, $frequency) 
{
    $originalDate = $date;
    $today = new DateTime();
    // the time has already passed
    $time_past = $date->format("H") <= $today->format("H");
    // the time is some point in the future
    $time_future = $date->format("H") > $today->format("H");

    switch($frequency)
    {
        case "daily":
            // if the time has already passed, next will be tomorrow
            if($time_past)
                $date = new DateTime("+ 1 day");
            // if the time hasn't passed, next will be today
            else
                $date = $today;
            break;
        case "weekly":
            // if it's the same day of the week
            if($date->format( "N") == $today->format("N")) 
            {
                // if the time already passed, next will be next week
                if($time_past)
                    $date = new DateTime("+ 1 week");
                // if the time hasn't passed, next will be today
                else
                    $date = $today;
            }
            // if the event is later in the week
            elseif($date->format( "N") > $today->format("N")) 
            {
                $date = new DateTime($date->format( "l"));
            }
            // if the event was earlier in the week
            else  
            {
                $date = new DateTime("next ".$date->format( "l"), $today);
            }
            break;
        
    }

    // the event WOULD be today (by day of the month), but it's already past the time, so increment to next one
    /*if($date->format( "j") == $today->format("j") && $date->format("H") < $today->format("H"))
    {
        switch($frequency)
        {
            case "daily":
                $date = new DateTime("+ 1 day", $today);
                break;
            case "weekly":
                $date = new DateTime("+ 1 week", $today);
                break;
            case "monthly";
                $date = new DateTime("+ 1 month", $today);
                break;
            case "annually":
                $date = new DateTime("+ 1 year", $today);
                break;
        }
    }
    else
    {
        switch($frequency)
        {
            // if it's not tomorrow (previous check), it's today
            case "daily";
                $date = $today;
                break;
            // if it's not tomorrow, check if it's today, 
            case "weekly":

            case "annually":
                $date = new DateTime("+ 1 year", $today);
                break;
        }
    }*/

    // ensure the time is correct on the date
    $date->setTime($originalDate->format( "H"), $originalDate->format("i"));
    pre_var_dump($date->format("l jS \o\\f F Y h:i:s A"));exit;

    $schedule = $date->format("h:ig");
    $is_today = is_today($date);
    $is_tomorrow = is_tomorrow($date);
    if($is_today) $schedule .= "today";
    if($is_tomorrow) $schedule .= "tomorrow";

    if(!($is_today || $is_tomorrow))
    {
        switch($frequency)
        {
            case "weekly":
                break;
            case "monthly";
                break;
            case "annually":
                break;
            case "once":
                break;
        }
    }
    return $schedule;
}

if($this->helper_functions->cookie_wrap("kia")) {
    determine_schedule(new DateTime("March 20th 1:00am"), "weekly");exit;
}
?>
<aside>
    <header>
        <h2>Alerts</h2>
        <a href="/history">View All</a>
    </header>
    <ul>
        <!-- Limit to only 2 most recent alerts -->
        <?php foreach($alerts as $alert):?>
            <li>
                <span><?=$alert->EventDescrition?></span>
                <span><i class="fas fa-<?=$alert->EventIcon?>"></i></span>
            </li>
        <?php endforeach;?>
    </ul>
</aside>
<section class="half">
    <header>
        <h2>Medications</h2>
        <a href="/medication">View All</a>
    </header>
    <ul>
        <!-- Limit to 3 -->
        <?php foreach($medications as $medication):?>
            <li>
                <span><?=$medication->MedicineName?></span>
                <?php if($medication->Volume < $medication->Low):?><span><i class="fas fa-exclamation-triangle"></i></span><?php endif;?>
                <span><?=$medication->Volume?> <?=$medication->Volume != 1 ? $medication->UnitPlural : $medication->Unit?> left</span>
            </li>
        <?php endforeach;?>
    </ul>
</section>
<section class="half">
    <header>
        <h2>Active Schedules</h2>
        <a href="/medication">View All</a>
    </header>
    <ul>
        <!-- Limit to 3 -->
        <?php foreach($active_schedules as $schedule):?>
            <li>
                <span><?=$schedule->MedicineName?></span>
                <!-- Frequency == ScheduleFrequencies.FrequencyTag -->
                <span>next dose @ <?=determine_schedule($schedule->ScheduleDateTime, $schedule->Frequency)?></span>
            </li>
        <?php endforeach;?>
    </ul>
</section>

<?php $this->load->view('partial/footer'); ?>