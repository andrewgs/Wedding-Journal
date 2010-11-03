<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <meta http-equiv="Pragma" content="no-cache"/> 
    <meta http-equiv="Cache-Control" content="no-cache"/> 
    <meta http-equiv="Expires" content="1 Jan 2000 0:00:00 GMT"/> 
	<meta name="language" content="ru" /> 
    <meta name="description" content=<?php echo $pagevalue['desc']; ?>/>
    <meta name="keywords" content=<?php echo $pagevalue['keyword']; ?>/>
    <title><?php echo $pagevalue['title']; ?></title>
	
	<?php define("CRLT", "\n"); ?>
	<?php echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/reset.css" type="text/css" />'.CRLT; ?>
	<?php echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/960.css" type="text/css" />'.CRLT; ?>
	<?php echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/style.css" type="text/css"/>'.CRLT; ?>
 
	<?php echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.min.js"></script>'.CRLT; ?>
		
	<script type="text/javascript"> 
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17193616-1']);
		_gaq.push(['_trackPageview']);
 
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('header',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
			<?php if(count($albums) > 0): ?>
				<div id="photo-gallery" class="container_12">
				<?php for($i = 0;$i < count($albums);$i++): ?>
					<div class="grid_5 photo-album">
						<div class="album-background">
						<?php $text='<img class="album-main-photo" src="'.$pagevalue['baseurl'].'album/viewimage/'.$albums[$i]['alb_id'].'"
									alt="'.$albums[$i]['alb_photo_title'].'"/>'; ?>
						<?php $link = 'photo-albums/photo-gallery/'.$albums[$i]['alb_id']; ?>
						<?php echo anchor($link,$text); ?>
						</div>
						<div class="album-text"> 
							<div class="album-title"><?php echo $albums[$i]['alb_title']; ?></div>
							<div class="album-amt"><?php echo 'Кадров - '.$albums[$i]['alb_amt']; ?></div>
							<div class="album-annotation"><?php echo $albums[$i]['alb_annotation']; ?></div>
						</div>
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
	<?php $this->load->view('footer'); ?>