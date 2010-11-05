<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "main";
$route['scaffolding_trigger'] = "";

/* Controller main*/
$route[''] = "main/index";
$route['signup'] = "main/signup";
$route['signup/themes'] = "main/choicetheme";
$route['signup/finish'] = "main/finish";
$route['page404'] = "main/page404";
$route['login']	= "main/authorization";
$route['capcha'] = "main/capcha";
$route['activation/([a-zA-Z0-9])*'] = "main/activation";

/* Controller Administrator*/
$route[':any/login'] = "administrator/login";
$route[':any/admin'] = "administrator/index";
$route[':any/logoff'] = "administrator/logoff";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event-new'] = "administrator/eventnew";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event-edit/:num'] = "administrator/eventedit";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event-destroy/:num'] = "administrator/eventdestroy";
/* Controller General*/
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*'] = "general/index";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums'] = "general/albums";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/album/viewimage/:num'] = "general/viewimage";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/friend/viewimage/:num'] = "general/viewimage";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/small/viewimage/:num'] = "general/viewimage";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/big/viewimage/:num'] = "general/viewimage";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums/photo-gallery/:num'] = "general/photo";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/events'] = "general/events";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/events/:num'] = "general/events";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event/:num'] = "general/event";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/friends'] = "general/friends";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/about'] = "general/about";
/* other */
$route[':any'] = "main/page404";