<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends Site_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
		// TODO: we need to pull the EventLogs with most recent first
		$options = array(
			'userID'=> 1,
			'order'=> 'desc'
		);
		// TODO: we need a list of filters that could be applied to EventLogs
		// before date
		if($before)
		{
				array_push($options, array('before' => $before));
		}
		//after date
		if($after)
		{
					array_push($options, array('after' => $after));
		}
		// creator
		//if($maker
		//{
				//	array_push($options, array('maker' => $maker));
		//}
		

			$history = $this->events_model->get($options, false);
		
		$this->set_view_data(array('history' => $history));

			
		}
	

	
}

