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
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/header'); ?>
		<div id="main">
			<?php $this->load->view('transitions/fullback'); ?>
			<div class="container_16">
				<?= form_error('title'); ?>
				<?= form_error('text'); ?>
				<div id="blog" class="grid_16">
					<div class="blog-content">
						<?php if($type == 'index'): ?>
							<?php $this->load->view('forms/frmindextext'); ?>
						<?php endif; ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
	<script>
		!window.jQuery && document.write(unescape('%3Cscript src="<?= $baseurl; ?>javascript/jquery-1.4.2.js"%3E%3C/script%3E'))
	</script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.maxlength-min.js"></script>
	<!-- scripts concatenated and minified via ant build script-->
	<script src="<?= $baseurl.$themeurl; ?>/javascript/plugins.js"></script>
	<script src="<?= $baseurl.$themeurl; ?>/javascript/script.js"></script>
	<!-- end concatenated and minified scripts-->
  	<!--[if lt IE 7 ]>
    	<script src="<?= $baseurl; ?>javascript/dd_belatedpng.js"></script>
    	<script> DD_belatedPNG.fix('img, .png_bg'); </script>
  	<![endif]-->
	<!-- yui profiler and profileviewer - remove for production -->
	<script src="<?= $baseurl.$themeurl; ?>/javascript/profiling/yahoo-profiling.min.js"></script>
	<script src="<?= $baseurl.$themeurl; ?>/javascript/profiling/config.js"></script>
	<!-- end profiling code -->
	<!-- change the UA-XXXXX-X to be your site's ID -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#indextext').maxlength({
				maxCharacters		: 245,
				status				: true,
				statusClass			: "lenghtstatus",
				statusText			: " символов осталось.",
				notificationClass	: "lenghtnotifi",
				slider				: true
			});
		});
	</script>
</body>
</html>