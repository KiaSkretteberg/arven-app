	<!DOCTYPE html>
<html>
<head>
	<title><?=$title ? $title . " | " : ''?>Arven</title>
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0"/>
	
	<link rel="stylesheet" type="text/css" href="/assets/css/mapsvg.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/styles.css?v=2">
	<link rel="stylesheet" type="text/css" href="/assets/css/<?=$this->uri->segment(1) ? str_replace('-', '_', $this->uri->segment(1)) : 'home'?>.css?v=2">
	
	<script src="/assets/js/jquery-2.1.3.js"></script>
	<script src="/assets/js/mapsvg.js"></script>
	<script src="/assets/js/main.js"></script>
	<script src="https://kit.fontawesome.com/285cb3eb3c.js" crossorigin="anonymous"></script>
	<?php if (isset($_GET['embed'])) :?>
		<style>
			body {
				overflow: hidden;
			}
		</style>
	<?php endif;?>
</head>
<body>
<?php if (!isset($_GET['exclude-header'])) :?>
	<header>
        <button class="sidenav-toggle">
            <div class="bar top"></div>
            <div class="bar middle"></div>
            <div class="bar bottom"></div>
        </button>
        <h1><a href="//app.rx-arven.com">Arven</a></h1>
        <nav class="primary full-screen">
            <ul>
                <li><a href="//app.rx-arven.com">Dashboard</a></li>
                <li><a href="//app.rx-arven.com/medication">Medications</a></li>
                <li><a href="//app.rx-arven.com/history">History</a></li>
                <li><a href="//app.rx-arven.com/configuration">Configuration</a></li>
            </ul>
        </nav>
    </header>
    <aside class="sidenav">
        <nav class="primary small-screen">
            <ul>
                <li><a href="//app.rx-arven.com">Dashboard</a></li>
                <li><a href="//app.rx-arven.com/medication">Medications</a></li>
                <li><a href="//app.rx-arven.com/history">History</a></li>
                <li><a href="//app.rx-arven.com/configuration">Configuration</a></li>
            </ul>
        </nav>
    </aside>
<?php endif;?>
	<section id="content" class="<?=$this->uri->segment(1) ? $this->uri->segment(1) : 'home'?>-page">
		<div class="wrapper">
			<?php if(isset($title)) :?><h2><?=$title?></h2><?php endif;?>
			<?php if($this->session->flashdata('success')): ?>
				<div class="success"><?php echo $this->session->flashdata('success');?></div>
			<?php endif; ?>
			<?php if($this->session->flashdata('error')): ?>
				<div class="error"><?php echo $this->session->flashdata('error');?></div>
			<?php endif; ?>
			<?php $errors = explode('<div/>', trim(validation_errors('<div/>', ''), '<div/>')); ?>
			<?php if(count($errors) <= 2):?>
				<?= validation_errors('<div class="error">', '</div>');?>
			<?php else:?>
				 <div class="error">There are still <?=count($errors)?> problems or required fields.</div>
			<?php endif; ?>