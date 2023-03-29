<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// TODO: This should be put in a library or something
function determine_schedule($date, $frequency) 
{
    $schedule;
    switch($frequency)
    {
        case "daily":
            $schedule = "Daily";
            break;
        case "weekly":
            $day = $date->format("D");
            // get the day as a single character, unless it's tues/thurs then 2 characters
            $schedule = ($day[0] == "T" ? substr($day, 0, 2) : $day[0]);
            break;
        case "monthly":
            $schedule = "on the " . $date->format("jS");
            break;
        case "annually":
            $schedule = $date->format("M jS");
            break;
    }
    $schedule .= ": ".$date->format("g:ia");
    return $schedule;
}

$this->load->view('partial/header');
?>
<div class="btn-holder">
    <a href="/medications/save" class="btn">
        <i class="fas fa-prescription-bottle-alt"></i>
        <span>Add Medication</span>
    </a>
</div>
<table>
    <thead>
        <tr class="grid">
            <th class="col-medication">Medication</th>
            <th class="col-remain">Remaining</th>
            <th class="col-schedule">Schedules</th>
            <th class="col-actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($medications as $medication):?>
            <tr class="grid" data-id="medicine-<?=$medication->MedicineID?>">
                <td class="col-medication"><?=$medication->MedicineName?></td>
                <td class="col-remain"><?=$medication->Volume?> <?=$medication->Volume != 1 ? $medication->UnitPlural : $medication->Unit?></td>
                <td class="col-schedule">
                    <button aria-label="modify schedules" class="js-modify-schedules">
                    <?php if($medication->schedules):?>
                        <?php $idx = 0; foreach($medication->schedules as $schedule): $idx++;?>
                            <?=determine_schedule(new DateTime($schedule->ScheduleDateTime), $schedule->Frequency);?><?php if(count($medication->schedules) > $idx):?>,<?php endif;?>
                        <?php endforeach;?>
                    <?php else:?>
                       <i class="fas fa-plus"></i> <span>Add Schedule</span>
                    <?php endif;?>
                    </button>
                </td>
                <td class="col-actions">
                    <!-- TODO: These links all need to work/do their appropriate tasks -->
                    <a class="tooltip btn" title="request delivery" aria-label="request one time delivery" href="/medications/request-delivery/<?=$medication->MedicineID?>"><i class="fas fa-route"></i></a>
                    <a class="tooltip btn" title="delete medication" aria-label="delete medication" href="/medications/delete/<?=$medication->MedicineID?>"><i class="fas fa-trash"></i></a>
                    <a class="tooltip btn" title="log a dose" aria-label="log a dose taken" href="/medicaitons/log-dose/<?=$medication->MedicineID?>"><i class="fas fa-capsules"></i></a>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>

<?php $this->load->view('partial/footer'); ?>