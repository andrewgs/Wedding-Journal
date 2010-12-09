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
	<link rel="stylesheet" href="<?= $baseurl; ?>css/pirobox.css" type="text/css" />
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
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?= $baseurl.$backpath; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
				<?php if($admin):?>
					<div id="internal_nav" class="grid_4">
						<a href="<?= $baseurl.$usite.'/photo-albums/photo-gallery/'.$album.'/upload'; ?>" style="text-align:center">Добавить фотографии</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="clear"></div>
			<div class="container_12">
				<?php $this->load->view('message');?>
				<?php if(count($images)):?>
					<div id="photo-gallery" class="container_12">
					<?php for($i = 0;$i < count($images);$i++): ?>
						<div class="grid_3 photo-album">
							<div class="album-background images">
							<?php $link = $baseurl.'users/'.$usite.'/images/'.$images[$i]['img_src']; ?>
							<?php $text = '<img src="'.$baseurl.$usite.'/photo/viewimage/'.$images[$i]['img_id'].'" 
										alt="'.$images[$i]['img_title'].'" '.'title="'.$images[$i]['img_title'].'"/>'; ?>
							<?php $attr = array('class'=>'pirobox','title'=>$images[$i]['img_title']); ?>
							<?= anchor($link,$text,$attr); ?>
							</div>
							<div class="images-text"> 
								<div class="image-title"><?= $images[$i]['img_title']; ?></div>
							</div>
							<div class="album-controls">
								<?php $text = 'Комментарии: '.$images[$i]['img_cmnt']; ?>
								<?php $str_uri = $baseurl.$usite.'/photo-albums/photo-comments/'.$images[$i]['img_id']; ?>
								<?= anchor($str_uri,$text); ?>
							</div>
							<div class="clear"></div>
							<?php if($admin):?>
								<div class="album-controls">
									<?php $text = 'Удалить'; ?>
									<?php $str_uri = $baseurl.$usite.'/photo-albums/photo-destory/'.$images[$i]['img_id']; ?>
									<?php $attr = array('class'=>'delete'); ?>
									<?= anchor($str_uri,$text,$attr); ?>
									<?php $text = 'На главной - '.$images[$i]['img_slideshow']; ?>
									<?php $str_uri = $baseurl.$usite.'/photo-albums/photo-slideshow/'.$images[$i]['img_id']; ?>
									<?php $attr = array('class'=>'slideshow'); ?>
									<?= anchor($str_uri,$text,$attr); ?>
								</div>
								<div class="clear"></div>
							<?php endif; ?>
						</div>
					<?php endfor; ?>
					</div>
					<div class="clear"></div>
				<?php endif; ?>
			</div>
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
	<script src="<?= $baseurl; ?>javascript/pirobox.min.js"></script>
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
		$(document).ready(function(){
			$().piroBox({
				my_speed: 400,
				bg_alpha: 0.1,
				slideShow : true,
				slideSpeed : 4,
				close_all : '.piro_close,.piro_overlay' 
			});
			<?php if($admin): ?>
				$('a.delete').confirm();
				$('a.slideshow').confirm({
					msg:'Изменить?',
	  				buttons: {
	    				wrapper:'<button></button>',
	    				separator:''
	  				}  
				});
			<?php endif; ?>
		});
	</script>
</body>
</html>