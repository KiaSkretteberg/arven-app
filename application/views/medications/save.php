<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<div class="btn-holder">
    <a href="/medications" class="btn">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Medications</span>
    </a>
</div>
<form action="" method="POST" class="grid">
    <div class="form-field medication__name">
        <label for="">Name *</label>
        <input type="text" name="name" required placeholder="e.g. ibuprofen" required value="<?=set_value("name", $medication->MedicineName)?>">
        <div class="form-error"><?=form_error("name", "**")?></div>
    </div> 

    <div class="form-field medication__quantity">
        <label for="">Dose Quantity *</label>
        <input type="text" name="dose" required  inputmode="numeric" placeholder="e.g. 1" required value="<?=set_value("dose", $medication->Dose)?>">
        <div class="form-error"><?=form_error("dose", "**")?></div>
    </div>

    <div class="form-field medication__units">
        <label for="">Dose Units *</label>
        <input type="text" name="unit" required placeholder="e.g. pill" value="<?=set_value("unit", $medication->Unit)?>">
        <div class="form-error"><?=form_error("unit", "**")?></div>
    </div>
    <div class="form-field medication__units-plural">
        <label for="">Dose Units (Plural)</label>
        <input type="text" name="unit_plural" placeholder="e.g. pills" value="<?=set_value("unit_plural", $medication->UnitPlural)?>">
        <div class="form-error"><?=form_error("unit_plural", "**")?></div>
    </div>
    <!-- TODO: How do we "reset" this value so that a calculated column will know what date to use as a base
    Perhaps we store a date in the medicaitons table that says when it was last refilled?
    Or do we use an event log to determine when a refill last happened? -->
    <div class="form-field medication__volume">
        <label for="">Starting Volume *</label>
        <input type="text" name="volume" required inputmode="numeric" placeholder="e.g. 30" value="<?=set_value("volume", $medication->Volume)?>">
        <div class="form-error"><?=form_error("volume", "**")?></div>
    </div>
    <div class="form-field medication__threshold">
        <label for="">Low Threshold</label>
        <input type="text" name="low_threshold" inputmode="numeric" placeholder="e.g. 10" value="<?=set_value("low_threshold", $medication->Low)?>">
        <div class="form-error"><?=form_error("low_threshold", "**")?></div>
    </div>

    <button type="submit">Save</button>
</form>

<?php if($medication) $this->load->view('schedules/index', array("schedules" => $medication->schedules, "latest_delivery" => $latest_delivery)); ?>

<?php $this->load->view('partial/footer'); ?>