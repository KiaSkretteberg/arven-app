<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// configuration controller
$route['setup'] = "configuration/initial";
$route['configuration/(.+)'] = "configuration/$1";
$route['configuration'] = "configuration";
// medication controller
$route['medication/(.+)'] = "medication/$1";
$route['medication'] = "medication";
// history controller
$route['history/(.+)'] = "history/$1";
$route['history'] = "history";
// login controller
$route['login/(.+)'] = "login/$1";
$route['login'] = "login";
// dashboard controller
$route['dashboard/(.+)'] = "dashboard/$1";
$route['dashboard'] = "dashboard";
// schedule controller
$route['schedules/(.+)'] = "schedules/$1";
$route['schedules'] = "schedules";
// api controller -- no index access
$route['api/(.+)'] = "api/$1";
// other pages
$route['(.+)'] = "router/$1";
$route['default_controller'] = 'router';
// 404 route
$route['404_override'] = '';
// dashes in url translate to underscores in controller names
$route['translate_uri_dashes'] = TRUE;
