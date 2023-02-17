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
<form action="" class="grid">
    <label for="">Your Email *</label>
    <input type="email" placeholder="e.g. john.smith@example.com" required>

    <label for="">Login Password *</label>
    <input type="password" placeholder="*****" required>

    <button>Login</button>
    <p>Don't have an account? <a href="/setup">Get started</a> first.</p>
</form>

<?php $this->load->view('partial/footer'); ?>