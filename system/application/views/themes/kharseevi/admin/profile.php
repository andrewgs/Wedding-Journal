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
	<link rel="stylesheet" href="<?= $baseurl.$themeurl; ?>/css/reset.css" type="text/css" /> 
	<link rel="stylesheet" href="<?= $baseurl.$themeurl; ?>/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?= $baseurl; ?>css/datepicker/jquery.ui.all.css" type="text/css" />
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery-1.4.2.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.bgiframe-2.1.1.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.datepicker-ru.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.confirm.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input#wedding-date").datepicker($.datepicker.regional['ru']);
			$('a.delete').confirm();
		});
	</script>
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/admin/header-admin'); ?>
		<div class="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?= $baseurl.$backpath; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
				<div id="internal_nav" class="grid_4">
					<a href="<?= $baseurl.$usite.'/admin/close'?>" style="text-align:center" class="delete">Удалить профиль</a>
				</div>
			</div>
			<div class="clear"></div>
			<div class="container_16">
				<div id="comment-form-content" class="grid_6 form-content">
					<?php $this->load->view('forms/frmprofile'); ?>
				</div>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>