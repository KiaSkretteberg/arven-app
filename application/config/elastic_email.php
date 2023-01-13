<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Elastic Email Details
| -------------------------------------------------------------------
|
|  These details are for the account rsvp@, each sub account gets a different api key and account id
|
|  api_key			string 		elastic email api key
|  accountID		string 		elastic email public account ID
|
*/


$config['elastic_email']['apiKey'] 		= '63c5cb68-8448-483d-ba37-cb9c6af64cc3';
$config['elastic_email']['accountID']	= '53474392-7816-416e-8450-db9afadd3ad7';


if($_SERVER['HTTP_X_FORWARDED_FOR'] == '24.65.62.182' || $_SERVER['REMOTE_ADDR'] == '24.65.62.182')
{
	$config['elastic_email']['apiKey'] 		= 'f57f1c57-2a1d-49db-a4cd-4dce42dc1071';
	$config['elastic_email']['accountID']	= '8f15c358-1965-41bd-b387-e67157342b0d';
}
