<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_functions
{
	private $ci;
	
	public function __construct()
	{
		$this->ci =& get_instance();
	}

	public function return_id($id = false)
	{
		if($this->ci->db->affected_rows() > 0)
		{
			return $id !== false && $id !== '0' ? $id : $this->ci->db->insert_id();
		}
		
		return false;
	}
	
	public function return_result($query, $result)
	{		
		if($query->num_rows() > 0)
		{
			return (($result !== true) ? $query->row() : $query->result());
		}
		
		return false;
	}

	public function create_hash($item = '', $hash = false, $include = true)
	{
		return md5($item . ($hash ? $hash : ($include ? rand(111111, 999999) : '')));
	}

	public function send_email($to, $subject, $message, $from_name = 'Arven App', $from_email = 'no-reply@rx-arven.com')
	{
		$this->ci->load->library('email');
		
		$this->ci->email->from($from_email, $from_name);
		
		$this->ci->email->to($to);
		
		$this->ci->email->subject($subject);

		$this->ci->email->message($message);
		
		return $this->ci->email->send();
	}

	function generate_password($password)
	{
		$hash = $this->create_hash(); //generate a password hash
				
		$salt = $this->create_hash($password, $hash); //salt the password
	
		return array('hash' => $hash, 'salt' => $salt);
	}

	function ip_wrap($network = 'devs')
	{
		switch($network) {
			case 'home':
				return ($_SERVER['HTTP_X_FORWARDED_FOR'] == '108.173.226.44' || $_SERVER['REMOTE_ADDR'] == '108.173.226.44');
			case 'boxclever':
				return ($_SERVER['HTTP_X_FORWARDED_FOR'] == '184.70.167.250' || $_SERVER['REMOTE_ADDR'] == '184.70.167.250' || constant('ENVIRONMENT') == 'local' || $_SERVER['HTTP_CF_CONNECTING_IP'] == '184.70.167.250');
			case 'devs':
			default: 
				return ($_SERVER['HTTP_X_FORWARDED_FOR'] == '184.68.249.62' || $_SERVER['REMOTE_ADDR'] == '184.68.249.62' || constant('ENVIRONMENT') == 'local' || $_SERVER['HTTP_CF_CONNECTING_IP'] == '184.68.249.62');
		}
	}

	/**
	 * Returns true or false depending on a browser cookie value
	 * @param String $cookie_value - The value of the cookie being set, usually your name!
	 * @param String $cookie_name - The name of the cookie, 9/10 this will be dev
	 * @return Boolean
	 */
	function cookie_wrap($cookie_value, $cookie_name = 'dev')
	{
		if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] === $cookie_value)
        {
                return true;
        } else {
                return false;
        }
	}
}