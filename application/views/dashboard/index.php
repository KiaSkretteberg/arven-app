<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<aside>
    <h2>Alerts</h2>
</aside>
<section class="half">
    <header>
        <h2>Medications</h2>
        <a href="/medication">View All</a>
    </header>
</section>
<section class="half">
    <header>
        <h2>Active Schedules</h2>
        <a href="/history">View All</a>
    </header>
</section>

<?php $this->load->view('partial/footer'); ?>