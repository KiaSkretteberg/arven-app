<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
set_include_path(APPPATH . 'libraries/' . PATH_SEPARATOR . get_include_path());

if (!class_exists('ElasticEmail\ApiClient')) {
  require_once APPPATH . 'libraries/ElasticEmail/autoload.php';
}

/**
 * This library is a codigniter style implementation of the php library for Elastic Email
 * it extends the api client because that seemed like the base class
 * @author Kia Skretteberg December 2016
 * 
 */
class Elastic_email extends ElasticEmail\ApiClient 
{
	//set up variables for the other files
	private $account;
	private $attachment;
	private $campaign;
	private $channel;
	private $contact;
	private $domain;
	private $email;
	private $export;
	private $eeList;
	private $log;
	private $segment;
	private $sms;
	private $survey;
	private $template;

	//codeigniter
	private $ci;

	//variables for the possible fields to be sent in an email

	private $subject = null;
	private $from = null;
	private $fromName = null;
	private $sender = null;
	private $senderName = null;
	private $replyTo = null;
	private $replyToName = null;
	private $to = null;
	private $cc = null;
	private $bcc = null;
	private $lists = null;
	private $segments = null;
	private $bodyHtml = null;
	private $bodyText = null;
	private $email_template = null;
	private $merge = null;
	private $attachments = null;

    function __construct($params = array()) 
    {
    	//codeigniter
		$this->ci =& get_instance();

		// Load config
        $this->ci->load->config('elastic_email');

        // Load required libraries, helpers, models,
        $this->ci->load->helper(array('array', 'text', 'url'));

        //api key
    	$this->apiKey = $this->ci->config->item('apiKey', 'elastic_email');
    	$this->SetApiKey($this->apiKey);
    	//public account id
    	$this->publicAccountID = $this->ci->config->item('accountID', 'elastic_email');


    	//in this library, none of these 
        $this->account = new ElasticEmail\Account();
		$this->attachment = new ElasticEmail\Attachment();
		$this->campaign = new ElasticEmail\Campaign();
		$this->channel = new ElasticEmail\Channel();
		$this->contact = new ElasticEmail\Contact();
		$this->domain = new ElasticEmail\Domain();
		$this->email = new ElasticEmail\Email();
		$this->export = new ElasticEmail\Export();
		$this->eeList = new ElasticEmail\EEList();
		$this->log = new ElasticEmail\Log();
		$this->segment = new ElasticEmail\Segment();
		$this->sms = new ElasticEmail\Sms();
		$this->survey = new ElasticEmail\Survey();
		$this->template = new ElasticEmail\Template();
    }


     /**
     * This function sets the any field that should be an array as either null or an array
     * @param $array Array or String (this could just be one item but it will be turned into an array)
     * @param $field String - what field to set
     * @return Void
     */
	private function _set_array_item($array, $field = 'to')
	{
		if(!$array) 
		{
			$this->$field = null; 
			return;
		}

		if(!is_array($array)) $array = array($array);

		$this->$field = $array;
	}

    /**
     * This function sets the "To" field for an email
     * @param $recipients  	String OR Array()
     *		String: must be format "user@example.com"
     *		Array is an array of emails formatted like above
     * @return Void
     */
	function to($recipients)
	{
		$this->_set_array_item($recipients);
	}

	/**
     * This function sets the "CC" field for an email
     * @param $recipients  	String OR Array()
     *		String: must be format "user@example.com"
     *		Array is an array of emails formatted like above
     * @return Void
     */
	function cc($recipients)
	{
		$this->_set_array_item($recipients, 'cc');
	}

	/**
     * This function sets the "BCC" field for an email
     * @param $recipients  	String OR Array()
     *		String: must be format "user@example.com"
     *		Array is an array of emails formatted like above
     * @return Void
     */
	function bcc($recipients)
	{
		$this->_set_array_item($recipients, 'bcc');
	}

	/**
     * This function sets the "Lists" field for an email
     * @param $lists  	String OR Array()
     *		String: name of a contact list to send to
     *		Array is an array of contact lists
     * @return Void
     */
	function lists($lists)
	{
		$this->_set_array_item($lists);
	}

	/**
     * This function sets the "Segments" field for an email
     * @param $segments  	String OR Array()
     *		String: name of a contact list to send to
     *		Array is an array of contact segments
     * @return Void
     */
	function segments($segments)
	{
		$this->_set_array_item($segments);
	}

	/**
     * This function sets the "From" name and email field for an email
     * @param $email  	String
     * @param $name  	String
     * @return Void
     */
	function from($email, $name = false)
	{
		$this->from = $email;
		if($name) $this->fromName = $name;
	}

	/**
     * This function sets the "Sender" name and email field for an email, unsure what this means currently
     * @param $email  	String
     * @param $name  	String
     * @return Void
     */
	function sender($email, $name = false)
	{
		$this->sender = $email;
		if($name) $this->senderName = $name;
	}

	/**
     * This function sets the "Reply-To" name and email field for an email
     * @param $email  	String
     * @return Void
     */
	function reply_to($email, $name = false)
	{
		$this->replyTo = $email;
		if($name) $this->replyToName = $name;
	}

	/**
     * This function sets the "Subject" field for an email
     * @param $subject  String
     * @return Void
     */
	function subject($subject)
	{
		$this->subject = $subject;
	}

	/**
     * This function sets the template to be used for the email
     * @param $subject  String - name of an email template
     * @return Void
     */
	function set_template($template)
	{
		$this->email_template = $template;
	}

	/**
	 * This function sets the "Html" and/or "Text" fields for an email
	 * @param $message  String OR Array()
	 *		string can either be plain text or html
	 *		array should be formatted as below, only 1 is really required
	 *		array (
	 *			'html' => 'string'
	 *			'text' => 'string'
	 *		)
	 * @return Void
	 */
	function message($message = '')
	{
		if(is_array($message))
		{
			$this->bodyHtml = $message['html'];
			$this->bodyText = $message['text'];
		}
		elseif(has_html($message))
		{
			$this->bodyHtml = $message;
			$this->bodyText = null;
		}
		else
		{
			$this->bodyText = $message;
			$this->bodyHtml = null;
		}
	}

	/**
     * This function sets the "Attachments" field for an email
     * @param $files array()
     *			should be formatted as follows
     *			array(
     *				array(
     *					"Name" => 'string'
     *              	"Type" => 'string'
     *              	"Content" => 'string'
     *				),
     *				array(
     *					"Name" => 'string'
     *              	"Type" => 'string'
     *              	"Content" => 'string'
     *				)
     *			)
     * @return Void
     */
	function attach($files)
	{
		$this->attachments = $files;
	}

	/**
	 * This function sets a value for any variables defined in a template
	 * @param $data array()
	 * 			should be formatted as follows
	 * 			array(
     * 				"variable" => "value",
     * 				"variable" => "value",
     * 			)
     *			where "variable" is the name of a variable used in the template i.e. firstname etc
     * @return Void
	 */
	function merge_data($data)
	{
		$this->merge = array();

		foreach($data as $key => $val)
		{
			$this->merge['merge_' . $key] = $val;
		}
	}

	/***************************************************

     Main Functions for talking to Elastic Email

     ****************************************************/



	/**
	 * This function sends an email based on parameters defined before calling the function. optionally allowing you to pass in overrides
	 * @param $options an optional array of options to overwrite defaults and parameters defined via other functions
	 * 		parameters you might consider overriding
	 *			isTransactional
	 *			timeOffSetMinutes
	 * @return 
	 */
    function send_email($options = array())
    {
    	$send_options = array(
    		'subject' => $this->subject,
	        'from' => $this->from,
	        'fromName' => $this->fromName,
	        'sender' => $this->sender,
	        'senderName' => $this->senderName,
	        'replyTo' => $this->replyTo,
	        'replyToName' => $this->replyToName,
	        'msgTo' => $this->to,
	        'msgCC' => $this->cc,
	        'msgBcc' => $this->bcc,
	        'lists' => $this->lists,
	        'segments' => $this->segments,
	        'bodyHtml' => $this->bodyHtml,
	        'bodyText' => $this->bodyText,
	        'template' => $this->email_template,
	        'merge' => $this->merge,
	        'timeOffSetMinutes' => null,
	        'isTransactional' => true //non bulk, non marketing, non commercial, should usually be true so long as not sending to lists of people
	    );

	    $options = array_intersect($options + $send_options, $send_options);

	    extract(filter_options(array('subject', 'from', 'fromName', 'sender', 'senderName', 'replyTo', 'replyToName', 'msgTo', 'msgCC', 'msgBcc', 'lists', 'segments', 'bodyHtml', 'bodyText', 'charset', 'template', 'merge', 'timeOffSetMinutes', 'isTransactional'), $options, null));
    	
    	try
    	{
    		$response = $this->email->Send(
    			$subject, 
    			$from, 
	    		$fromName, 
	    		$sender, 
	    		$senderName, 
	    		null, 
	    		null, 
	    		$replyTo, 
	    		$replyToName, 
	    		array(), 
	    		($msgTo ? $msgTo : array()), 
	    		($msgCC ? $msgCC : array()), 
	    		($msgBcc ? $msgBcc : array()), 
	    		($lists ? $lists : array()), 
	    		($segments ? $segments : array()), 
	    		null, 
	    		null, 
	    		$bodyHtml, 
	    		$bodyText, 
	    		null, 
	    		null, 
	    		null, 
	    		1, 
	    		$template, 
	    		($this->attachments ? $this->attachments : array()), 
	    		array(), 
	    		null, 
	    		($merge ? $merge : array()), 
	    		$timeOffSetMinutes, 
	    		null, 
	    		$isTransactional
	    	);

	    	$this->clear();
	    }
	    catch(Exception $e) //don't know what would trigger this, haven't encountered it yet
	    {
	    	$response = array('error' => $e);
	    }

	    return $response;
    }

    /**
	 * This function sends an sms message based on parameters passed into the function
	 * @param $options an optional array of options to overwrite defaults and parameters defined via other functions
	 * 		parameters you might consider overriding
	 * @return 
	 */
    function send_sms($phone_number, $message)
    {
    	try 
        {
        	$response = $this->sms->send($phone_number, $message);
        }
        catch(Exception $e)
        {
        	$response = array('error' => $e);
        }
        return $response;
    }

    function add_contact($options = array())
    {
    	extract(filter_options(array('emails', 'firstName', 'lastName', 'title', 'organization', 'industry', 'city', 'country', 'state', 'zip', 'listID', 'status', 'notes', 'consentDate', 'consentIP'), $options, null));

    	if($emails && !is_array($emails)) $emails = array($emails);
    	if(!$status) $status = 'Active';

    	try 
        {
        	$response = $this->contact->QuickAdd($emails, $firstName, $lastName, $title, $organization, $industry, $city, $country, $state, $zip, $listID, $status, $notes, $consentDate, $consentIP);
    	}
    	catch(Exception $e)
    	{
    		$response = array('error' => $e);
    	}

    	return $response;
    }

    function export_bounce_log()
    {
    	// var_dump($this->log->Export(array('0')));exit;
    }



    function clear()
    {
    	$this->subject = null;
		$this->from = null;
		$this->fromName = null;
		$this->sender = null;
		$this->senderName = null;
		$this->replyTo = null;
		$this->replyToName = null;
		$this->to = null;
		$this->cc = null;
		$this->bcc = null;
		$this->lists = null;
		$this->segments = null;
		$this->bodyHtml = null;
		$this->bodyText = null;
		$this->email_template = null;
		$this->merge = null;
		$this->attachments = null;
    }
}
