<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<meta http-equiv="Pragma" content="no-cache"/>
	<meta http-equiv="Cache-Control" content="no-cache"/>
	<meta http-equiv="Expires" content="1 Jan 2000 0:00:00 GMT"/>
	<meta name="language" content="ru" />
	<meta name="description" content="<?= $description; ?>"/>
	<meta name="keywords" content="<?= $keywords; ?>"/>
	<title><?= $title; ?></title>
	<link rel="stylesheet" href="<?= $baseurl; ?>css/960.css" type="text/css" />
	<link rel="stylesheet" href="<?= $baseurl; ?>css/signup.css" type="text/css" />
	<link rel="stylesheet" href="<?= $baseurl; ?>css/datepicker/jquery.ui.all.css" type="text/css" />
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery-1.4.2.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.bgiframe-2.1.1.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.datepicker-ru.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.widget.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input#wedding-date").datepicker($.datepicker.regional['ru']);
		});
	</script>
</head>
<body>
 	<h1 align="center">Свадьба - ты хоть за яйца меня подвесь, ну ее на ...!</h1>
	<div class="" style="text-align:center">
		<div class="">Добро пожаловать в систему создания свадебных сайтов</div>
	</div>
	<?php $this->load->view('forms/frmsignup');?>
</body>
</html>