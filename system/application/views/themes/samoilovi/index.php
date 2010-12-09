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
		<div id="main">
			<div class="container_12">
				<div id="slogan" class="grid_12">
					<img src="<?= $baseurl.$themeurl;?>/images/slogan.png" alt="Любовь нечаянно нагрянет, когда ее совсем не ждешь."/>
				</div>
			</div>
			<div class="clear"></div>
			<div id="content-info">
				<div class="container_16">
					<div class="grid_13">
						<div id="arrow-left"> </div>
						<div id="media-stream">
							<div id="media-stream-border"> </div>
							<div id="slideshow-holder">
								<?php for($i = 0;$i < count($images);$i++): ?>
									<img src="<?= $baseurl.'users/'.$usite.'/images/'.$images[$i]['src']; ?>" alt="<?= $images[$i]['title']; ?>" title="<?= $images[$i]['title']; ?>" width="558" height="371" >
								<? endfor; ?>
							 </div>
						 </div>
						<div id="arrow-right"> </div>
					</div>
					<div class="grid_3">
						<?php if($admin): ?>
							<div id="summaries">
								<span class="separated">
									<a href="<?= $baseurl.$usite.'/index/text-change'; ?>">Редактировать</a>
								</span>
							</div>
							<div class="clear"></div>
						<?php endif; ?>
						<div id="text-stack">
							<div class="merried"><?= $wedtext; ?></div>
							<div class="merried-days"><?= $wedday.' '.$days; ?></div>
							<p><?= $pagetext['text']; ?></p>
							<div class="signature"><?= $pagetext['title']; ?></div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
    	</div>
		<footer>
			<div id="events" class="container_12">
			<?php for($i = 0;$i < count($events);$i++): ?>
				<div class="grid_4">
					<div class="border-sep">
						<h2><?= $events[$i]['evnt_date']; ?></h2>
						<?php $link = $usite.'/event/'.$events[$i]['evnt_id'].'#event_'.$events[$i]['evnt_id']; ?>
					<p><?= $events[$i]['evnt_text'].anchor($link,' Читать далее'); ?></p>
					</div>
				</div>
			<?php endfor; ?>
			</div>
		</footer>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
	<script>
		!window.jQuery && document.write(unescape('%3Cscript src="<?= $baseurl; ?>javascript/jquery-1.4.2.js"%3E%3C/script%3E'))
	</script>
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
	</script>
</body>
</html>