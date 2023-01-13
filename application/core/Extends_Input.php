<?php 

class Extends_Input extends CI_Input
{
	public function files($index = '', $key = '', $xss_clean = FALSE)
	{
		return $this->_fetch_from_array($_FILES[$index], $key, $xss_clean);
	}
	
	function _sanitize_globals()
	{
		$this->_allow_get_array = TRUE;
		parent::_sanitize_globals();
	}
}