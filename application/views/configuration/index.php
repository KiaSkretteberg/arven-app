<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<div class="form-field">
    <label for="">Device Serial</label>
    <input type="text" readonly value="<?=$user->SerialNum?>">
</div>
<div class="btn-holder">
    <!-- <button>
        <i class="fas fa-map-marker-alt"></i>
        <span>Connect Tracker</span>
    </button> -->
    <!-- <button>
        <i class="fas fa-tram"></i>
        <span>Locate Stairs</span>
    </button> -->
    <!-- TODO (Kia): Is this a thing we can even control programmatically? -->
    <button>
        <i class="fas fa-power-off"></i>
        <span>Reboot Device</span>
    </button>
    <!-- TODO: Hook this up so that it sets a flag or something somewhere that the robot can query the server for -->
    <button>
        <i class="fas fa-heartbeat"></i>
        <span>Run Diagnostics</span>
    </button>
    <!-- TODO (Kia): What does this button do? -->
    <button>
        <i class="fas fa-sync"></i>
        <span>Factory Reset</span>
    </button>
</div>
<form action="" method="POST" class="grid">
    <div class="form-field">
        <label for="">Timezone</label>
        <?php $this->load->view('partial/timezone_list', array("timezones" => $timezones, "default" => $user->Timezone)); ?>
        <div class="form-error"><?=form_error("timezone", "**")?></div>
    </div>   

    <div class="form-field">
        <label for="">Your Email *</label>
        <input type="email" name="email" placeholder="e.g. john.smith@example.com" required value="<?=set_value("email", $user->Email)?>">
        <div class="form-error"><?=form_error("email", "**")?></div>
    </div> 

    <div class="form-field">
        <label for="">Your First Name *</label>
        <input type="text" name="first_name" placeholder="e.g. John" required value="<?=set_value("first_name", $user->FirstName)?>">
        <div class="form-error"><?=form_error("first_name", "**")?></div>
    </div>

    <div class="form-field">
        <label for="">Your Last Name</label>
        <input type="text" name="last_name" placeholder="e.g. Smith" value="<?=set_value("last_name", $user->LastName)?>">
        <div class="form-error"><?=form_error("last_name", "**")?></div>
    </div>

    <button type="submit">Update</button>
</form>

<?php $this->load->view('partial/footer'); ?>