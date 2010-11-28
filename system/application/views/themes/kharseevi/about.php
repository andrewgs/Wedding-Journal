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
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.min.js"></script>
	<script type="text/javascript"> 
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17193616-1']);
		_gaq.push(['_trackPageview']);
		(function(){
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga,s);
		})();
	</script>
</head>
<body>
	<div id="main-wrap">
	<?php $this->load->view($themeurl.'/header'); ?>
		<div id="content">
			<div class="container_12">
				<?php if($admin): ?>
					<div id="internal_nav" class="grid_4">
						<a href="<?= $baseurl.$usite.'/about/photo-change'; ?>">Сменить фотографию &nbsp;&rarr;</a>
					</div>
				<div class="clear"></div>
				<?php $this->load->view('message');?>
				<?php endif; ?>
				<?php if(!empty($image['oisrc'])): ?>
				<div id="about-us" class="grid_12">
					<img src="<?= $baseurl.'users/'.$usite.'/images/'.$image['oisrc']; ?>" alt="" title="<?= $image['oititle']; ?>">
					<div id="text-about">
						<span><?= $text; ?></span>
					</div>				
				</div>
				<?php endif; ?>			
			</div>
			<div class="clear"></div>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>