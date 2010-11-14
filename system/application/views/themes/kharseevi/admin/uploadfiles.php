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
	<link rel="stylesheet" href="<?= $baseurl; ?>css/pirobox.css" type="text/css" />
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery-1.3.1.min.js"></script>	
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/pirobox.min.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.confirm.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.MultiFile.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.form.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.blockUI.js"></script>
	<script type="text/javascript" src="<?= $baseurl.$themeurl; ?>/javascript/cfgmupload.js"></script>
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/admin/header-admin'); ?>
		<div id="content">
			<?php $this->load->view('transitions/fullback');?>
			<div class="container_12">
				<?php if($admin):?>
					<?php $this->load->view('message');?>
					<?php $this->load->view('forms/frmupload'); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>