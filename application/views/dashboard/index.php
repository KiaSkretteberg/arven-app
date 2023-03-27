<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');

// TODO: This should be put in a library or something
function determine_schedule($date, $frequency) 
{
    $today = now();

    // the event WOULD be today, but it's already past the time, so increment to next one
    if($date->format("j") == $today->format("j") && $date->format("H") < $today->format("H"))
    {
        switch($frequency)
        {
            case "daily":
                $date = $today->modify("+ 1 day");
                break;
            case "weekly":
                $date = $today->modify("+ 1 week");
                break;
            case "monthly";
                $date = $today->modify("+ 1 month");
                break;
            case "annually":
                $date = $today->modify("+ 1 year");
                break;
        }
    }
    // the date passed earlier this month, so go to next month/year
    elseif($date->format("j") < $today->format("j"))
    {
        switch($frequency)
        {
            case "monthly";
                $date = $today->modify("+ 1 month");
                break;
            case "annually":
                $date = $today->modify("+ 1 year");
                break;
        }
    }

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
        <?php foreach($medications as $medication):?>
            <li>
                <span><?=$medication->MedicineName?></span>
                <?php if($medication->Volume < $medication->Low):?><span></span><?php endif;?>
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