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
		
	<script type="text/javascript"> 
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17193616-1']);
		_gaq.push(['_trackPageview']);
		(function(){
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		$(document).ready(function(){
			$().piroBox({
				my_speed: 400,
				bg_alpha: 0.1,
				slideShow : true,
				slideSpeed : 4,
				close_all : '.piro_close,.piro_overlay' 
			});
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
					<a href="<?= $baseurl.$backpath; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
				<?php if($admin):?>
					<div id="internal_nav" class="grid_4">
						<a href="<?= $this->uri->uri_string().'/upload'; ?>" style="text-align:center">Добавить фотографии</a>
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
</body>
</html>