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
$route['restore'] = "main/passrestore";
$route['page403'] = "main/page403";
$route['not-existing'] = "main/notexisting";
$route['closed-site'] = "main/closesite";

/* Controller Administrator*/
$route[':any/login'] = "administrator/login";
$route[':any/admin'] = "administrator/index";
$route[':any/logoff'] = "administrator/logoff";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event-new'] = "administrator/eventnew";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event-edit/:num'] = "administrator/eventedit";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event-destroy/:num'] = "administrator/eventdestroy";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event/comment-edit/:num/:num'] = "administrator/commentedit";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums/comment-edit/:num/:num'] = "administrator/commentedit";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event/comment-destroy/:num/:num'] = "administrator/commentdestroy";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums/comment-destroy/:num/:num'] = "administrator/commentdestroy";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/friend-new'] = "administrator/friendnew";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/friend-edit/:num'] = "administrator/friendedit";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/friend-destroy/:num'] = "administrator/frienddestroy";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/album-new'] = "administrator/albumnew";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/album-edit/:num'] = "administrator/albumedit";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/album-destroy/:num'] = "administrator/albumdestroy";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/about/photo-change'] = "administrator/photochange";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/admin/profile'] = "administrator/profile";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/admin/password'] = "administrator/passwordchange";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/admin/theme'] = "administrator/themechange";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/admin/close'] = "administrator/profileclose";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums/photo-gallery/:num/upload'] = "administrator/uploadfiles";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/admin/multi-upload'] = "administrator/multiupload";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/admin/comments'] = "administrator/commentslist";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/admin/comments/:num'] = "administrator/commentslist";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums/photo-destory/:num'] = "administrator/photodestroy";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums/photo-slideshow/:num'] = "administrator/photoslideshow";

/* Controller General*/
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*'] = "general/index";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums'] = "general/albums";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/album/viewimage/:num'] = "general/viewimage";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/friend/viewimage/:num'] = "general/viewimage";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo/viewimage/:num'] = "general/viewimage";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums/photo-gallery/:num'] = "general/photo";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/photo-albums/photo-comments/:num'] = "general/photocomments";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/events'] = "general/events";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/events/:num'] = "general/events";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/event/:num'] = "general/event";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/friends'] = "general/friends";
$route['([a-zA-Z]){1}([a-zA-Z0-9_])*/about'] = "general/about";
/* other */
$route[':any'] = "main/page404";