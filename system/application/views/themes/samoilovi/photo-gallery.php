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
<?php
	define("CRLT", "\n");
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/reset.css" type="text/css" />'.CRLT; 
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/960.css" type="text/css" />'.CRLT; 
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/style.css" type="text/css" />'.CRLT;
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/pirobox.css" type="text/css" />'.CRLT;
	
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.min.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/pirobox.min.js"></script>'.CRLT;
?> 
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
		});
	</script>  	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('header',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?php echo $pagevalue['baseurl'].$pagevalue['backpath']; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="container_12">
			<?php if(count($images)):?>
				<div id="photo-gallery" class="container_12">
				<?php for($i = 0;$i < count($images);$i++): ?>
					<div class="grid_3 photo-album">
						<div class="album-background images">
						<?php $link = $pagevalue['baseurl'].'big/viewimage/'.$images[$i]['img_id']; ?>
						<?php $text = '<img src="'.$pagevalue['baseurl'].'small/viewimage/'.$images[$i]['img_id'].'" 
									alt="'.$images[$i]['img_title'].'" '.'title="'.$images[$i]['img_title'].'"/></a>'; ?>
						<?php $attr = array('class'=>'pirobox'); ?>
						<?php echo anchor($link,$text,$attr); ?>
						</div>
						<div class="images-text"> 
							<div class="image-title"><?php echo $images[$i]['img_title']; ?></div>
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
	<?php $this->load->view('footer'); ?>