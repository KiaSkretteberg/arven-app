<?
class Extends_Email extends CI_Email
{
	/**
	 * Function to retrieve the header string
	 * @return String $this->_header_str
	 */
	public function get_header_str()
	{
		return $this->_header_str;
	}

	/**
	 * Function to retrieve the headers being set for this email
	 * @return Array $this->_headers
	 */
	public function get_headers()
	{
		return $this->_headers;
	}

	/**
	 * Set FROM - extended to allow changing the return path
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function from($from, $name = '', $return_path = false)
	{
		if (preg_match( '/\<(.*)\>/', $from, $match))
		{
			$from = $match['1'];
		}

		if ($this->validate)
		{
			$this->validate_email($this->_str_to_array($from));
		}

		// prepare the display name
		if ($name != '')
		{
			// only use Q encoding if there are characters that would require it
			if ( ! preg_match('/[\200-\377]/', $name))
			{
				// add slashes for non-printing characters, slashes, and double quotes, and surround it in double quotes
				$name = '"'.addcslashes($name, "\0..\37\177'\"\\").'"';
			}
			else
			{
				$name = $this->_prep_q_encoding($name, TRUE);
			}
		}

		$this->set_header('From', $name.' <'.$from.'>');
		$this->set_header('Return-Path', '<'.($return_path ? $return_path : $from).'>');

		return $this;
	}

	/**
	 * Send using SMTP
	 *
	 * @access	protected
	 * @return	bool
	 */
	protected function _send_with_smtp()
	{
		if ($this->smtp_host == '')
		{
			$this->_set_error_message('lang:email_no_hostname');
			return FALSE;
		}

		//initialize codeigniter for use with logging to the mail table and preventing sending emails from offline sites
		$this->ci =& get_instance(); 
		$this->ci->load->helper('file');
		
		$this->_smtp_connect();
		$this->_smtp_authenticate();

		$this->_send_command('from', $this->clean_email($this->_headers['Return-Path']));

		$recipients = '';
		foreach ($this->_recipients as $val)
		{
			$recipients .= ($recipients != '' ? ',' : '') . $val;
			$this->_send_command('to', $val);
		}

		if (count($this->_cc_array) > 0)
		{
			foreach ($this->_cc_array as $val)
			{
				if ($val != "")
				{
					$recipients .= ($recipients != '' ? ',' : '') . $val;
					$this->_send_command('to', $val);
				}
			}
		}

		if (count($this->_bcc_array) > 0)
		{
			foreach ($this->_bcc_array as $val)
			{
				if ($val != "")
				{
					$recipients .= ($recipients != '' ? ',' : '') . $val;
					$this->_send_command('to', $val);
				}
			}
		}

		$this->_send_command('data');

		$this->_send_data($this->_header_str . preg_replace('/^\./m', '..$1', $this->_finalbody));

		$this->_send_data('.');

		$reply = $this->_get_smtp_data();

		$this->_set_error_message($reply);

		if (strncmp($reply, '250', 3) != 0)
		{
			$this->_set_error_message('lang:email_smtp_error', $reply);
			return FALSE;
		}

		$this->_send_command('quit');
		return TRUE;
	}

}