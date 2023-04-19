<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('partial/header');
?>
<div class="form-field">
    <label for=""></label>
    <input type="text" placeholder="Enter a value to search by..." name="search">
</div>

<div class="btn-holder">
    <div class="filters">
        <button class="add-filter button-link">Filter +</button>
        <?php foreach($filters as $filter):?>
            <button>
                <span><?=$filter?></span>
                <span>x</span>
            </button>
        <?php endforeach;?>

        
    </div>
</div>

<section class="full">
<?php 
// TODO - display history
            var_dump($history->EventName);
         ?>
</section>

<?php $this->load->view('partial/footer'); ?>