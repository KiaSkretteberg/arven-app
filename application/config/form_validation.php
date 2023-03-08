<?php

$config = array
(
	'setup' => array
	(
		array
		(
			'field' => 'serial',
			'label' => 'device serial',
			'rules' => 'required|trim|callback_serial_exists'
		),
		array
		(
			'field' => 'first_name',
			'label' => 'your first name',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'last_name',
			'label' => 'your last name',
			'rules' => 'trim'
		),
		array
		(
			'field' => 'email',
			'label' => 'your email',
			'rules' => 'required|trim|valid_email|callback_email_unique'
		),
		array
		(
			'field' => 'password',
			'label' => 'login password',
			'rules' => 'required|trim|callback_password_complexity'
		),
	),
	'configuration' => array
	(
		array
		(
			'field' => 'first_name',
			'label' => 'your first name',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'last_name',
			'label' => 'your last name',
			'rules' => 'trim'
		),
		array
		(
			'field' => 'email',
			'label' => 'your email',
			'rules' => 'required|trim|valid_email'
		)
	)
);

?>