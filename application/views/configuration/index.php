<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<section>
    <?php foreach($devices as $device):?>
        <p><?=$device->SerialNum?></p>
    <?php endforeach;?>
</section>

<?php $this->load->view('partial/footer'); ?>