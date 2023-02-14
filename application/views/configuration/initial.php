<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('partial/header', array("exclude_header" => true));
?>
<div class="banner">
    <h2>Say Hello to <em class="accent">Arven</em>:</h2>
    <p>
        Your Personal Medication Assitant
    </p>
</div>
<form action="" class="grid">
    <label for="">Device Serial *</label>
    <input type="text" placeholder="e.g. RX-AR2023-XXXX" required>

    <label for="">Timezone</label>
    <select>
        <option value="America/Edmonton">America/Edmonton (MST) -7:00</option>
    </select>

    <label for="">Your First Name *</label>
    <input type="text" placeholder="e.g. John" required>

    <label for="">Your Last Name</label>
    <input type="text" placeholder="e.g. Smith">

    <label for="">Your Email *</label>
    <input type="email" placeholder="e.g. john.smith@example.com" required>

    <label for="">Login Password *</label>
    <input type="password" placeholder="*****" required>

    <button>Let's Go!</button>
</form>

<?php $this->load->view('partial/footer'); ?>