<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<main>
    <div class="banner">
        <div>
            <h2></h2>
            <p>
                From Latin <i>arveho</i> - Meaning "carry", "bring", or "convey".<br>
                Also from the name <i>Arvin</i> - Meaning "friend"
            </p>
        </div>
    </div>
    <?php foreach($users as $user):?>
        <p>User Name: <?=$user->first_name?></p>
        <p>User Email: <?=$user->email?></p>
        <?php $count = 0; foreach($user->schedules as $schedule): $count++;?>
        <p>
            Schedule <?=$count?>: <?=$schedule->frequency?>
            <?php if($schedule->frequency == "Daily"):?> @ <?=date('g:i A',$schedule->date) ?><?php endif;?>
            <?php if($schedule->frequency == "Weekly"):?> on <?=date('l',$schedule->date) ?><?php endif;?>
            <?php if($schedule->frequency == "Monthly"):?> on the <?=date('jS',$schedule->date) ?><?php endif;?>
        </p>
        <?php endforeach;?>
    <?php endforeach;?>
    <nav>
        <ul class="quick-nav">
            <li><a href="#">Sample</a></li>
        </ul>
    </nav>
</main>

<?php $this->load->view('partial/footer'); ?>