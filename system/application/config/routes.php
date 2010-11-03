<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] 					= "main";
$route['scaffolding_trigger'] 					= "";

/* Controller main*/
$route[''] 										= "main/index";
$route['signup']								= "main/signup";
$route['signup/themes']							= "main/choicetheme";
$route['signup/finish']							= "main/finish";
$route['page404']								= "main/page404";
$route['login']									= "main/authorization";
$route['capcha']								= "main/capcha";
$route['activation/([a-zA-Z0-9])*']				= "main/activation";

/* Controller Administrator*/
$route[':any/login']							= "administrator/login";
$route[':any/admin'] 							= "administrator/index";
$route[':any/logoff'] 							= "administrator/logoff";

/* Controller General*/
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*']			= "general/index";

/* other */
$route[':any']									= "main/page404";