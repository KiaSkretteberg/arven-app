<?php
/*
| -------------------------------------------------------------------
| ENVIRONMENT CONFIG FILE
| -------------------------------------------------------------------
| Welcome to the one and only environment.config.php file! If this is 
| your first time here, take a look around, make yourself at home.
| 
| This file is used to setup the configurable files used by a specific
| environment. This may include stuff required by codeigniter or
| WebGuide specific variables.
|
| Currently this file is only loaded into index.php
*/

$environment['root_path'] = '/var/www/app.rx-arven.com';

//Define the required paths that codeigniter uses
$environment['application_path'] = $environment['root_path'].'/application';
$environment['system_path'] = $environment['root_path'].'/system';