<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
 	<title><?= $title; ?></title>
 	<meta name="description" content="<?= $description; ?>">
 	<meta name="keywords" content="<?= $keywords; ?>"/>
 	<meta name="author" content="<?= $author; ?>">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link rel="shortcut icon" href="<?= $baseurl.$themeurl; ?>/favicon.ico">
 	<link rel="apple-touch-icon" href="<?= $baseurl.$themeurl; ?>/apple-touch-icon.png">
	<link rel="stylesheet" href="<?= $baseurl; ?>css/960.css?v=1" type="text/css" />
	<link rel="stylesheet" href="<?= $baseurl.$themeurl; ?>/css/style.css?v=2" type="text/css" />
 	<script src="<?= $baseurl; ?>javascript/modernizr-1.6.min.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.min.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.maxlength-min.js"></script>
	<script type="text/javascript"> 
		$(document).ready(function(){
			$('#annotation').maxlength({
					maxCharacters		: 125,
					status				: true,
					statusClass			: "lenghtstatus",
					statusText			: " символов осталось.",
					notificationClass	: "lenghtnotifi",
					slider				: true
			});
		});
		</script>  	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/header'); ?>
		<div id="main">
			<?php $this->load->view('transitions/fullback');?>
			<div class="container_16">
				<?= form_error('title'); ?>
				<?= form_error('photo_title'); ?>
				<?= form_error('userfile'); ?>
				<?= form_error('annotation'); ?>
				<div id="blog" class="grid_16">
					<div class="blog-content">
						<?php $this->load->view('forms/frmalbum'); ?>
					 </div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>