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
			'label' => 'first name',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'last_name',
			'label' => 'last name',
			'rules' => 'trim'
		),
		array
		(
			'field' => 'email',
			'label' => 'email',
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
			'label' => 'first name',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'last_name',
			'label' => 'last name',
			'rules' => 'trim'
		),
		array
		(
			'field' => 'email',
			'label' => 'email',
			'rules' => 'required|trim|valid_email'
		)
	),
	'login' => array
	(
		array
		(
			'field' => 'email',
			'label' => 'email',
			'rules' => 'required|trim|valid_email|callback_verify_login'
		),
		array
		(
			'field' => 'password',
			'label' => 'password',
			'rules' => 'required|trim'
		),
	),
	'save_medication' => array
	(
		array
		(
			'field' => 'name',
			'label' => 'name',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'dose',
			'label' => 'dose quantity',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'unit',
			'label' => 'dose units',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'unit_plural',
			'label' => 'dose units plural',
			'rules' => 'trim'
		),
		array
		(
			'field' => 'volume',
			'label' => 'starting volume',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'low_threshold',
			'label' => 'low threshold',
			'rules' => 'trim'
		),
	),
	'save_frequency' => array
	(
		array
		(
			'field' => 'frequency',
			'label' => 'frequency',
			'rules' => 'required|trim'//|callback_valid_frequency'
		),
		array
		(
			'field' => 'date',
			'label' => 'date',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'time',
			'label' => 'time',
			'rules' => 'required|trim'
		),
	),
);

?>