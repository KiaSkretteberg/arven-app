<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH.'core/Controller.php');

class Site_Controller extends CI_Controller
{
	public $view_data;
	
	public $view_file;
		
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
 	}
 	
	function _remap($method)
	{
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