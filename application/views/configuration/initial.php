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
    <label for="">Device Serial *</label>
    <input type="text" name="serial" placeholder="e.g. RX-AR2023-XXXX" required value="<?=$this->input->post("serial")?>">

    <label for="">Timezone</label>
    <select name="timezone">
        <?php foreach($timezones as $timezone):?>
            <option value="<?=$timezone?>"<?=$timezone == ($this->input->post("timezone") ? $this->input->post("timezone") : $default_timezone) ? ' selected' : ''?>><?=$timezone?></option>
        <?php endforeach;?>
    </select>

    <label for="">Your First Name *</label>
    <input type="text" name="first_name" placeholder="e.g. John" required value="<?=$this->input->post("first_name")?>">

    <label for="">Your Last Name</label>
    <input type="text" name="last_name" placeholder="e.g. Smith" value="<?=$this->input->post("last_name")?>">

    <label for="">Your Email *</label>
    <input type="email" name="email" placeholder="e.g. john.smith@example.com" required value="<?=$this->input->post("email")?>">

    <label for="">Login Password *</label>
    <input type="password" name="password" placeholder="*****" required value="<?=$this->input->post("password")?>">

    <button type="submit">Let's Go!</button>

    <p>Already have an account? <a href="/login">Login</a> instead.</p>
</form>

<?php $this->load->view('partial/footer'); ?>