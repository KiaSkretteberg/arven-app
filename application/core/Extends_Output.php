<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Output Class
 *
 * Responsible for sending final output to browser
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Output
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/output.html
 */
class Extends_Output extends CI_Output {
	
	function platform_detect()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		
		switch(true)
		{	
			case (preg_match('/ipad/i',$user_agent));
				$status = 'Apple iPad';
				break;
			
			case (preg_match('/ipod/i',$user_agent)||preg_match('/iphone/i',$user_agent));
				$status = 'Apple';
				break;
			
			case (preg_match('/android/i',$user_agent));
				$status = 'Android';
				break;
			
			case (preg_match('/blackberry/i',$user_agent));
				$status = 'Blackberry';
				break;
			
			default;
				$status = 'Other';
		} 
		
		return $status;
		  
	}
}