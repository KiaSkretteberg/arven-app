<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<aside>
    <header>
        <h2>Alerts</h2>
        <a href="/history">View All</a>
    </header>
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
</section>

<?php $this->load->view('partial/footer'); ?>