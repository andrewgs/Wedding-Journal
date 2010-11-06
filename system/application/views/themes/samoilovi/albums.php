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
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.confirm.js"></script>
	<script type="text/javascript"> 
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17193616-1']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		$(function(){
			$('a.delete').confirm();
		});
	</script>
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/header'); ?>
		<div id="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?=$baseurl.$usite.'/album-new'; ?>">Создать новый альбом &nbsp;&rarr;</a>
				</div>
				<div class="clear"></div>
				<?php $this->load->view('message');?>
			<div class="clear"></div>
			<?php if(count($albums) > 0): ?>
				<div id="photo-gallery" class="container_12">
				<?php for($i = 0;$i < count($albums);$i++): ?>
					<div class="grid_5 photo-album">
						<div class="album-background">
						<?php $text='<img class="album-main-photo" src="'.$baseurl.$usite.'/album/viewimage/'.$albums[$i]['alb_id'].'"
									alt="'.$albums[$i]['alb_photo_title'].'"/>'; ?>
						<?php $link = $usite.'/photo-albums/photo-gallery/'.$albums[$i]['alb_id']; ?>
						<?php echo anchor($link,$text); ?>
						</div>
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
</body>
</html>