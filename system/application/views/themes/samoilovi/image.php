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
				<div id="internal_nav" class="grid_4">
					<a href="<?= $baseurl.$backpath; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
				<div id="internal_nav" class="grid_4">
					<a href="#comment" style="text-align:center">Оставить комментарий</a>
				</div>
				<div class="clear"></div>
				<?php $this->load->view('message');?>
			</div>
			<div class="clear"></div>
			<div class="container_16">
				<?= form_error('user_name'); ?>
				<?= form_error('user_email'); ?>
				<?= form_error('cmnt_text'); ?>
				<div class="grid_4 photo-album">
					<div class="album-background images">
						<img src="<?= $image['src']; ?>" alt="" title="<?=$image['title'] ?>" height="<?=$image['height']; ?>" width="<?=$image['wight']; ?>" align="left">
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<?php for($i = 0;$i < count($comments);$i++): ?>
			<div class="container_16">
				<div class="comment grid_12">
					<a name="comment_<?= $comments[$i]['cmnt_id'];?>"></a>
					<span class="user" id="<?= $comments[$i]['cmnt_id'];?>">
					<?php if(!empty($comments[$i]['cmnt_web'])): ?>
						<a title="" target="_blank" href="<?= $comments[$i]['cmnt_web'];?>"><?= $comments[$i]['cmnt_usr_name'];?></a>
					<?php else: ?>
						<?= $comments[$i]['cmnt_usr_name']; ?>	
					<?php endif; ?>
					</span>
					<span class="dates"><?= $comments[$i]['cmnt_usr_date'];?></span>
					<p><?= $comments[$i]['cmnt_text']; ?></p>
					<div class="clear"></div>
					<?php if($admin): ?>
						<div>
							<?php $text = 'Редактировать'; ?>
							<?php $link = $usite.'/photo-albums/comment-edit/'.$comments[$i]['cmnt_img_id'].'/'.$comments[$i]['cmnt_id']; ?>
							<?= anchor($link,$text).' | '; ?>
							<?php $text = 'Удалить'; ?>
							<?php $link = $usite.'/photo-albums/comment-destroy/'.$comments[$i]['cmnt_img_id'].'/'.$comments[$i]['cmnt_id']; ?>
							<?php $attr = array('class'=>'delete'); ?>
							<?= anchor($link,$text,$attr); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endfor; ?>
			<div class="container_16">
				<div id="comment-form-content" class="grid_10 form-content">
				<a name="comment"></a>
					<?php $this->load->view('forms/frmcomment');?>
				</div>
				<div class="clear"></div>
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