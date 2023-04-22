<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<aside>
    <header>
        <h2>Alerts</h2>
        <a href="/history">View All</a>
    </header>
    <?php if($alerts):?>
        <ul>
            <?php foreach($alerts as $alert):?>
                <li>
                    <span><?=$alert->EventDescription?></span>
                    <span><i class="fas fa-<?=$alert->EventIcon?>"></i></span>
                </li>
            <?php endforeach;?>
        </ul>
    <?php else:?>
        <p>No active alerts.</p>
    <?php endif;?>
</aside>
<section class="full">
    <header>
        <h2>Status</h2>
    </header>
    <ul>
        <li>Location: <?= $location->EventDescription?></li>
        <li>Connection: <?= $connection->EventDescription?></li>
        <li>Battery: <?= $battery->EventDescription?></li>
    </ul>
</section>
<section class="half">
    <header>
        <h2>Medications</h2>
        <a href="/medications">View All</a>
    </header>
    <ul>
        <?php foreach($medications as $medication):?>
            <li>
                <span><?=$medication->MedicineName?></span>
                <span>
                    <?php if($medication->VolumeRemaining < $medication->Low):?><span><i class="fas fa-exclamation-triangle tooltip" title="<?=$medication->MedicineName?> running low"></i></span><?php endif;?> 
                    <?=$medication->VolumeRemaining?> <?=$medication->VolumeRemaining != 1 ? $medication->UnitPlural : $medication->Unit?> left
                </span>
            </li>
        <?php endforeach;?>
    </ul>
</section>
<section class="half">
    <header>
        <h2>Active Schedules</h2>
        <a href="/medications">View All</a>
    </header>
    <ul>
        <?php foreach($active_schedules as $schedule): ?>
            <li>
                <span><?=$schedule->MedicineName?></span>
                <span>next dose @ <?=determine_next_delivery(new DateTime($schedule->ScheduleDateTime), $schedule->Frequency)?></span>
            </li>
        <?php endforeach;?>
    </ul>
</section>

<?php $this->load->view('partial/footer'); ?>