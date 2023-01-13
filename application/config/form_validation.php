<?php

$config = array
(
	//RSVP
	'rsvp' => array
	(
		array
		(
			'field' => 'name',
			'label' => 'name',
			'rules' => 'required|trim'
		)
	),
	'update_address' => array
	(
		array
		(
			'field' => 'city',
			'label' => 'city',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'province',
			'label' => 'province',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'postal_code',
			'label' => 'postal code',
			'rules' => 'required|trim'
		),
		array
		(
			'field' => 'address',
			'label' => 'address',
			'rules' => 'required|trim'
		)
	)
);

?>