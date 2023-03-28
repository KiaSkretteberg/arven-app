<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');

// TODO: This should be put in a library or something
function determine_schedule($date, $frequency) 
{
    // create a copy of the original date for use later
    $originalDate = clone $date;
    // grab an instance of today
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
            if($date->format("N") == $today->format("N")) 
            {
                // if the time already passed, next will be next week
                if($time_past)
                    $date = new DateTime("+ 1 week");
                // if the time hasn't passed, next will be today
                else
                    $date = $today;
            }
            // if the event is later in the week
            elseif($date->format("N") > $today->format("N")) 
            {
                $date = new DateTime($date->format("l"));
            }
            // if the event was earlier in the week
            else  
            {
                $date = new DateTime("next ".$date->format("l"));
            }
            break;
        case "monthly":
            // if it's the same day of the month
            if($date->format("j") == $today->format("j")) 
            {
                // if the time already passed, next will be next month
                if($time_past)
                    $date = new DateTime("+ 1 month");
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
                    $date = new DateTime("+ 1 year");
                // if the time hasn't passed, next will be today
                else
                    $date = $today;
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