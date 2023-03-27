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
        <label for="email">Your Email *</label>
        <input type="email" name="email" id="email" placeholder="e.g. john.smith@example.com" required value="<?= set_value('email'); ?>">
        <div class="form-error"><?=form_error("email", "**")?></div>
    </div>

    <div class="form-field">
        <label for="password">Login Password *</label>
        <input type="password" name="password" id="password" placeholder="*****" required>
        <div class="form-error"><?=form_error("password", "**")?></div>
    </div>

    <button type="submit">Login</button>
    <p>Don't have an account? <a href="/setup">Get started</a> first.</p>
</form>

<?php $this->load->view('partial/footer'); ?>