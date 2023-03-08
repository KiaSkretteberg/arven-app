<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('partial/header', array("exclude_header" => true));
?>
<div class="banner">
    <h2>Say Hello to <em class="accent">Arven</em>:</h2>
    <p>
        Your Personal Medication Assistant
    </p>
</div>
<form action="" method="POST" class="grid">
    <div class="form-field">
        <label for="">Device Serial *</label>
        <input type="text" name="serial" placeholder="e.g. RX-AR2023-XXXX" required value="<?= set_value('serial'); ?>">
       <div class="form-error"><?=form_error("serial", "**")?></div>
    </div>  

    <div class="form-field">
        <label for="">Timezone</label>
        <?php $this->load->view('partial/timezone_list', array("timezones" => $timezones, "default" => $default_timezone)); ?>
       <div class="form-error"><?=form_error("timezone", "**")?></div>
    </div>    

    <div class="form-field">
        <label for="">Your First Name *</label>
        <input type="text" name="first_name" placeholder="e.g. John" required value="<?=set_value("first_name")?>">
       <div class="form-error"><?=form_error("first_name", "**")?></div>
    </div>

    <div class="form-field">
        <label for="">Your Last Name</label>
        <input type="text" name="last_name" placeholder="e.g. Smith" value="<?=set_value("last_name")?>">
       <div class="form-error"><?=form_error("last_name", "**")?></div>
    </div>

    <div class="form-field">
        <label for="">Your Email *</label>
        <input type="email" name="email" placeholder="e.g. john.smith@example.com" required value="<?=set_value("email")?>">
       <div class="form-error"><?=form_error("email", "**")?></div>
    </div>

    <div class="form-field">
        <label for="">Login Password *</label>
        <input type="password" name="password" placeholder="*****" required value="<?=set_value("password")?>">
       <div class="form-error"><?=form_error("password", "**")?></div>
    </div>
    
    <button type="submit">Let's Go!</button>

    <p>Already have an account? <a href="/login">Login</a> instead.</p>
</form>

<?php $this->load->view('partial/footer'); ?>