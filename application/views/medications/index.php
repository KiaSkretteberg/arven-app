<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<div class="btn-holder">
    <a href="/medications/add" class="btn">
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
                <td class="col-remain"><?=$medication->VolumeRemaining?> <?=$medication->VolumeRemaining != 1 ? $medication->UnitPlural : $medication->Unit?></td>
                <td class="col-schedule">
                    <button aria-label="modify schedules" class="js-modify-schedules button-link">
                    <?php if($medication->schedules):?>
                        <?php $idx = 0; foreach($medication->schedules as $schedule): $idx++;?>
                            <?=determine_schedule(new DateTime($schedule->ScheduleDateTime), $schedule->Frequency);?><?php if(count($medication->schedules) > $idx):?>,<?php endif;?>
                        <?php endforeach;?>
                    <?php else:?>
                       <span>+ Add Schedule</span>
                    <?php endif;?>
                    </button>
                </td>
                <td class="col-actions">
                    <a class="tooltip btn" title="edit medication" aria-label="edit medication" href="/medications/edit/<?=$medication->MedicineID?>"><i class="fas fa-edit"></i></a>
                    <a class="tooltip btn" title="request delivery" aria-label="request one time delivery" href="/medications/request-delivery/<?=$medication->MedicineID?>"><i class="fas fa-route"></i></a>
                    <a class="tooltip btn" title="delete medication" aria-label="delete medication" href="/medications/delete/<?=$medication->MedicineID?>"><i class="fas fa-trash"></i></a>
                    <a class="tooltip btn" title="log a dose" aria-label="log a dose taken" href="/medications/log-dose/<?=$medication->MedicineID?>"><i class="fas fa-capsules"></i></a>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>

<?php $this->load->view('partial/footer'); ?>