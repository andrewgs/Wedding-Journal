﻿<!doctype html>
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
	<noscript>
		<div id="noscript">
			<p>Этот веб-сайт оптимизирован для современных, соответствующих стандартам веб-браузеров с включенным Javascript.<br>
			Для лучшего качества отображения необходимо включить поддержку Javascript в вашем браузере.</p>
			<!--
			<p>This website is optimized for modern, standards-compliant web browsers with Javascript enabled.<br>
			For a better viewing experience please enable Javascript in your browser.</p>
			-->
		</div>
	</noscript>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/header'); ?>
		<div id="main" class="mt10">
			<?php if($admin): ?>
			<div class="container_12">
				<div id="summaries" class="grid_4 suffix_2">
					<span class="separated">
						<a href="<?=$baseurl.$usite.'/album-new'; ?>">Создать новый альбом &nbsp;&rarr;</a>
					</span>
				</div>
				<div class="clear"></div>
				<?php $this->load->view('message');?>
			<?php endif; ?>
			<div class="clear"></div>
			<?php if(count($albums) > 0): ?>
				<div id="photo-gallery" class="container_12">
				<?php for($i = 0;$i < count($albums);$i++): ?>
					<div class="grid_6 photo-album">
						<div class="album-background">
						<?php $text='<img class="album-main-photo" src="'.$baseurl.$usite.'/album/viewimage/'.$albums[$i]['alb_id'].'"
									alt="'.$albums[$i]['alb_photo_title'].'"/>'; ?>
						<?php $link = $usite.'/photo-albums/photo-gallery/'.$albums[$i]['alb_id']; ?>
						<?= anchor($link,$text); ?>
						</div>
						<div class="album-content"> </div>
						<div class="album-text"> 
							<div class="album-title"><?= $albums[$i]['alb_title']; ?></div>
							<div class="album-amt"><?= 'Кадров - '.$albums[$i]['alb_amt']; ?></div>
							<div class="album-annotation"><?= $albums[$i]['alb_annotation']; ?></div>
						</div>
						<?php if($admin): ?>
							<div class="album-controls">
								<?php
									$text 		= 'Редактировать';
									$str_uri 	= $usite.'/album-edit/'.$albums[$i]['alb_id'];
									echo anchor($str_uri,$text);
									$text 		= 'Удалить';
									$str_uri 	= $usite.'/album-destroy/'.$albums[$i]['alb_id'];
									$attr 		= array('class'=>'delete');
									echo anchor($str_uri,$text,$attr);
								?>
							</div>
						<?php endif; ?>
						<div class="clear"></div>
					</div>
				<?php endfor; ?>
				<div class="clear"></div>
				</div>
			<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
	<script>
		!window.jQuery && document.write(unescape('%3Cscript src="<?= $baseurl; ?>javascript/jquery-1.4.2.js"%3E%3C/script%3E'))
	</script>
	<?php if($admin): ?>
		<script src="<?= $baseurl; ?>javascript/jquery.confirm.js"></script>
	<?php endif; ?>
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
	<script>
		var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
		(function(d, t) {
		var g = d.createElement(t),
		    s = d.getElementsByTagName(t)[0];
		g.async = true;
		g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g, s);
		})(document, 'script');
		<?php if($admin): ?>
			$(function(){
				$('a.delete').confirm();
			});
		<?php endif; ?>
	</script>
</body>
</html>