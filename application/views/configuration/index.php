<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<section>
    <div class="form-field">
        <label for="">Device Serial</label>
        <input type="text" readonly value="<?=$devices[0]->SerialNum?>">
    </div>
</section>

<?php $this->load->view('partial/footer'); ?>