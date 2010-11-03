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
	
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.min.js"></script>'.CRLT; 
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/swfobject.js"></script>'.CRLT; 
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/base.js"></script>'.CRLT; 
?>
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
	<?php $this->load->view('header',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_16">
				<div id="slogan" class="grid_16">
				<?php echo '<img src="'.$pagevalue['baseurl'].'images/slogan.png" alt="Мы пестрыми нотами споем вам о любви"/>'; ?>
				</div>
			</div>
			<div class="clear"></div>
			<div id="content-info">
				<div class="container_16">
					<div class="grid_10">
						<div id="arrow-left"> </div>
						<div id="media-stream">
							<div id="vimeo_player_holder"> </div>
						 </div>
						<div id="arrow-right"> </div>
					</div>
					<div class="grid_4 suffix_2">						
						<div id="photo-stack"> </div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="footer">
			<div id="events" class="container_12">
			<?php for($i = 0;$i < count($events);$i++): ?>
				<div class="grid_4">
				<?php echo '<h2>'.$events[$i]['evnt_date'].'</h2>'; ?>
				<?php $link = 'event/'.$events[$i]['evnt_id'].'#event_'.$events[$i]['evnt_id']; ?>
				<?php echo '<p>'.$events[$i]['evnt_text'].anchor($link,' Читать далее ').'</p>'; ?>
				</div>
			<?php endfor; ?>
			</div>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('footer'); ?>