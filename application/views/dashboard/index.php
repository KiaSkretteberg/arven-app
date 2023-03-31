<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
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
        <a href="/medications">View All</a>
    </header>
    <ul>
        <?php foreach($medications as $medication):?>
            <li>
                <span><?=$medication->MedicineName?></span>
                <!-- TODO: Instead of Volume, we need to pull this data as a calculated column based on logs -->
                <?php if($medication->Volume < $medication->Low):?><span><i class="fas fa-exclamation-triangle"></i></span><?php endif;?>
                <span><?=$medication->Volume?> <?=$medication->Volume != 1 ? $medication->UnitPlural : $medication->Unit?> left</span>
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