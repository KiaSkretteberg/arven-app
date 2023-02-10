<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<main>
    <div class="banner">
        <div>
            <h2>Say Hello to <em>Arven<em>:</h2>
            <p>
                Your Personal Medication Assitant
            </p>
        </div>
    </div>
    <form action="">
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

        <button>Get Started</button>
    </form>
</main>

<?php $this->load->view('partial/footer'); ?>