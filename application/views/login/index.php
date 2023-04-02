<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('partial/header', array("exclude_header" => true));
?>
<div class="banner">
    <h1><img src="/assets/logo-white.svg" alt="Arven"></h1>
    <h2><em class="accent">Arven</em> missed you...</h2>
    <p>
        Welcome back!
    </p>
</div>
<form action="" method="POST" class="grid">
    <div class="form-field">
        <label for="email">Email *</label>
        <input type="email" name="email" id="email" placeholder="e.g. john.smith@example.com" required value="<?= set_value('email'); ?>">
        <div class="form-error"><?=form_error("email", "**")?></div>
    </div>

    <div class="form-field">
        <label for="password">Password *</label>
        <input type="password" name="password" id="password" placeholder="*****" required>
        <div class="form-error"><?=form_error("password", "**")?></div>
    </div>

    <button type="submit">Login</button>
    <p>Haven't met Arven yet? <a href="/setup">Connet with Arven</a> now.</p>
</form>

<?php $this->load->view('partial/footer'); ?>