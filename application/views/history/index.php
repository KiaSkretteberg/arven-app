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
        <button class="add-filter">Filter +</button>
        <?php foreach($filters as $filter):?>
            <button>
                <span><?=$filter?></span>
                <span>x</span>
            </button>
        <?php endforeach;?>
        <!-- TODO: Remove this is just test for styling -->
        <button class="filter">
            <span>Test Filter 1</span>
            <span>x</span>
        </button>
        <button class="filter">
            <span>Test Filter 2</span>
            <span>x</span>
        </button>
        <button class="filter">
            <span>Test Filter 3</span>
            <span>x</span>
        </button>
        <button class="filter">
            <span>Test Filter 1</span>
            <span>x</span>
        </button>
        <button class="filter">
            <span>Test Filter 2</span>
            <span>x</span>
        </button>
        <button class="filter">
            <span>Test Filter 3</span>
            <span>x</span>
        </button>
    </div>
</div>

<section class="full"></section>

<?php $this->load->view('partial/footer'); ?>