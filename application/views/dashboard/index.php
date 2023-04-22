<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<section class="full status-bar">
    <header>
        <h2>Status</h2>
    </header>
    <ul>
        <li>
            <span>Location: <?= $location->EventDescription?></span>
            <span><i class="fas fa-<?=$location->EventIcon?>"></i></span>
        </li>
        <li>
            <span>Connection: <?= $connection->EventDescription?></span>
            <span><i class="fas fa-<?=$connection->EventIcon?>"></i></span>
        </li>
        <li>
            <span>Battery: <?= $battery->EventDescription?></span>
            <span><i class="fas fa-<?=$battery->EventIcon?>"></i></span>
        </li>
    </ul>
</section>
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