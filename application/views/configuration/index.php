<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<div class="form-field">
    <label for="">Device Serial</label>
    <input type="text" readonly value="<?=$devices[0]->SerialNum?>">
</div>
<div class="btn-holder">
    <button>
        <i class="fas fa-tram"></i>
        <span>Locate Stairs</span>
    </button>
    <button>
        <i class="fas fa-power-off"></i>
        <span>Reboot Device</span>
    </button>
    <button>
        <i class="fas fa-heartbeat"></i>
        <span>Run Diagnostics</span>
    </button>
    <button>
        <i class="fas fa-sync"></i>
        <span>Factory Reset</span>
    </button>
</div>
<form action="" method="POST" class="grid">
    <div class="form-field">
        <label for="">Timezone</label>
        <select name="timezone">
            <?php foreach($timezones as $timezone):?>
                <option value="<?=$timezone?>"<?=$timezone == ($this->input->post("timezone") ? $this->input->post("timezone") : $default_timezone) ? ' selected' : ''?>><?=$timezone?></option>
            <?php endforeach;?>
        </select>
    </div>   

    <div class="form-field">
        <label for="">Your Email *</label>
        <input type="email" name="email" placeholder="e.g. john.smith@example.com" required value="<?=$this->input->post("email")?>">
    </div> 

    <div class="form-field">
        <label for="">Your First Name *</label>
        <input type="text" name="first_name" placeholder="e.g. John" required value="<?=$this->input->post("first_name")?>">
    </div>

    <div class="form-field">
        <label for="">Your Last Name</label>
        <input type="text" name="last_name" placeholder="e.g. Smith" value="<?=$this->input->post("last_name")?>">
    </div>

    <button type="submit">Update</button>
</form>

<?php $this->load->view('partial/footer'); ?>