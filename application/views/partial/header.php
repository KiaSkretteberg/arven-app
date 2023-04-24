<?php 
$page_tag = $this->uri->segment(1) ? str_replace('-', '_', $this->uri->segment(1)) : 'home';
function active_page($tag, $page_tag) { return $page_tag == $tag; }
function active_page_class($tag, $page_tag)  { return active_page($tag, $page_tag) ? ' class="active"' : '';  }
function active_page_aria($tag, $page_tag) { return active_page($tag, $page_tag) ? ' aria_current="page"' : '';  }?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$title ? $title . " | " : ''?>Arven</title>
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0"/>
	
	<link rel="stylesheet" type="text/css" href="/assets/css/styles.css?v=1">
	<link rel="stylesheet" type="text/css" href="/assets/css/full-page.css?v=1">
	<?php if(file_exists(SITEPATH."assets/css/$page_tag.css")):?>
		<link rel="stylesheet" type="text/css" href="/assets/css/<?=$page_tag?>.css?v=1">
	<?php endif;?>
	
	<script src="/assets/js/jquery-2.1.3.js"></script>
	<script src="/assets/js/main.js"></script>
	<?php if(file_exists(SITEPATH."assets/js/$page_tag.js")):?>
		<script src="/assets/js/<?=$page_tag?>.js?v=1"></script>
	<?php endif;?>
	<script src="https://kit.fontawesome.com/285cb3eb3c.js" crossorigin="anonymous"></script>
	<?php if (isset($_GET['embed'])) :?>
		<style>
			body {
				overflow: hidden;
			}
		</style>
	<?php endif;?>
</head>
<body class="grid<?=$page_tag == "login" || $page_tag == "setup" ? ' full-page' : ''?>">
<?php if (!isset($_GET['exclude-header']) && !$exclude_header) :?>
	<header class="header load-content">
		<nav>
			<h1><a href="//app.rx-arven.com"><img src="/assets/logo-white.svg" alt="Arven"></a></h1>
			<?php $pages = array(
				array("url" => "dashboard", "tag" => "dashboard", "icon" => "tachometer-alt", "name" => "Dashboard"),
				array("url" => "medications", "icon" => "prescription", "name" => "Medications"),
				// array("url" => "history", "icon" => "history", "name" => "History"),
				array("url" => "configuration", "icon" => "cog", "name" => "Configuration"),
			);?>
			<?php foreach($pages as $page): $tag = $page["tag"] ?? $page["url"]?>
			<a href="//app.rx-arven.com/<?=$page["url"]?>"<?=active_page_aria($tag, $page_tag)?><?=active_page_class($tag, $page_tag)?>>
				<i class="fas fa-<?=$page["icon"]?>"></i>
				<span><?=$page["name"]?></span>
			</a>
			<?php endforeach;?>
		</nav>
    </header>
<?php endif;?>
	<main class="grid <?=$this->uri->segment(1) ? $this->uri->segment(1) : 'home'?>-page<?=$this->uri->segment(2) == "add" || $this->uri->segment(2) == "edit" ? " save-page" : ($this->uri->segment(2) ? " ". $this->uri->segment(2) . "-page" : "")?>">
			<?php if(isset($title)) :?><h2><?=$title?></h2><?php endif;?>
			<?php if($this->session->flashdata('success')): ?>
				<?php $this->load->view('partial/message', array("message_type" => "success"));?>
			<?php endif; ?>
			<?php if($this->session->flashdata('error')): ?>
				<?php $this->load->view('partial/message', array("message_type" => "error"));?>
			<?php endif; ?>
			<?php $error_string = trim(validation_errors('<div/>', ''), '<div/>'); 
				$errors = explode('<div/>', $error_string);
				$error_count = count($errors); 
				if(!empty($error_string) && $error_count > 0):?>
				<?php $this->load->view('partial/message', array(
					"message_type" => "error",
					"message" => "There ".($error_count != 1 ? "were" : "was")." $error_count error".($error_count != 1 ? "s" : "")." in your submission. Please review the fields for errors and try again."
				));?>
			<?php endif; ?>