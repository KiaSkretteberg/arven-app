<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<main>
    <div class="banner">
        <div>
            <h2></h2>
            <p>
                
            </p>
        </div>
    </div>
    <section>
        <?php foreach($devices as $device):?>
            <p><?=$device->SerialNum?></p>
        <?php endforeach;?>
    </section>
</main>

<?php $this->load->view('partial/footer'); ?>