<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH.'core/Controller.php');

class Site_Controller extends CI_Controller
{
	public $view_data;
	
	public $view_file;

	protected $userID = null;

	protected $userName = null;
		
    function __construct()
    {
        parent::__construct();

        $this->view_file = false;
        
        //Set a default model to load.
        $model = ucwords($this->router->class).'_model';

        //Does the default model exist?
		if(file_exists(APPPATH . 'models/' . $model . '.php'))
		{
			//Load the default model.
			$this->load->model(strtolower($model), 'model');
		}

		$this->load->model(array(
			"schedule_frequencies_model",
			"devices_model",
			"users_model",
			"medicines_model",
			"schedules_model",
			"events_model",
			"deliveries_model"
		));
		
		$this->load->helper(array(
			"schedule"
		));
		
		// check for an authenticated user
		$this->userID = $this->session->userdata("UserID");
		$this->userName = $this->session->userdata("Name");


		// We need this set to the current user's timezone from the database
		// get which timezone user is in
		$user = $this->users_model->get(array(
			'id'=> $this->userID
		), false);

		$timezone = "America/Edmonton";
		
		if($user)
		{
			$timezone = $user->Timezone;
		}
		// store timezone in session for later use
		$this->session->set_userdata("timezone", $timezone);

		// list of pages that do not require an authenticated user
		$non_authenticated_pages = array("login", "setup");

		// if we're on a page that does not require authentication but we're authenticated, redirect us to the dashboard
		if(in_array($this->uri->segment(1), $non_authenticated_pages) && $this->userID)
		{
			redirect("/dashboard");
		}
		// if we're on a page that DOES require authenticatedion and we're NOT authenticated, redirect to login
		elseif(!in_array($this->uri->segment(1), $non_authenticated_pages) && !$this->userID)
		{
			redirect("/login");
		}
 	}
 	
	function _remap($method)
	{
		// if this is the api domain, and the controller isn't the api, take us to the api 
		if($_SERVER["HTTP_HOST"] == "api.rx-arven.com" && $this->router->class != "api")
		{
			redirect("/api" . ($method != "index" ? "/$method" : ""));
		}

		//Is does the requested controller/action exist?
		if(method_exists($this, $method))
		{
			//Call the requested controller/action.
			call_user_func_array(array($this, $method), array_slice($this->uri->rsegments, 1));
			
			//Set a the default view to load.
			$view = $this->router->class . '/' . $this->router->method;
			
			//Is there a view override set?
			if(($this->view_file !== false) && (file_exists(APPPATH . 'views/' . $this->view_file . '.php')))
			{
				$this->load->view($this->view_file, $this->view_data);
			}
			elseif(($this->view_file !== false) && (file_exists(APPPATH . 'views/' . $this->router->class . '/'. $this->view_file . '.php')))
			{
				$this->load->view($this->router->class . '/' . $this->view_file, $this->view_data);
			}
			elseif(file_exists(APPPATH . 'views/' . $view . '.php'))
			{
				//Load the default view.
				$this->load->view($view, $this->view_data);
			}
		}
		else
		{
			//Nothing to see here, Throw a 404 error.
			show_404();
		}
	}

	function set_view_data($index, $value = true)
	{
		//Was an array submitted?
		if(is_array($index))
		{
			//Loop threw the array.
			foreach($index as $key => $value)
			{
				$this->view_data[$key] = $value;
			}
		}
		else
		{
			$this->view_data[$index] = $value;
		}
	}
	
	function set_view_file($view)
	{
		$this->view_file = $view;
	}
}