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
	</script>  	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('header',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<?php $cnt = 0; ?>
			<?php for($i = 0;$i < $key/3;$i++): ?>	
			<div class="container_16 friend-vcards">
			<?php for($y = 0;$y < 3;$y++): ?>	
				<div class="grid_5 vcard">
					<div class="friend-info left">
					<?php echo '<img src="'.$pagevalue['baseurl'].'friend/viewimage/'.$friendcard[$i][$y]['id'].'"
									alt="'.$friendcard[$i][$y]['name'].'"/>'; ?>
					</div>
					<div class="friend-specs left">
						<div class="friend-name">
							<?php echo $friendcard[$i][$y]['name']; ?>
						</div>
						<div class="friend-profession">
							<?php echo $friendcard[$i][$y]['profession']; ?>
						</div>
					<?php if($friendcard[$i][$y]['social'] != 0):?>
							<div class="friend-social">
						<?php for($soc = 0;$soc < count($social); $soc++):
								if ($social[$soc]['soc_fr_id'] == $friendcard[$i][$y]['id'])	
									echo anchor($social[$soc]['soc_href'],$social[$soc]['soc_name'],array('target'=>'_blank')).' ';
							endfor; ?>
							</div>
					<?php endif; ?>						
						<hr/>
					</div>
					<div class="clear"></div>
					<div class="friend-note">
					<?php echo $friendcard[$i][$y]['note'];?>
					</div>
				</div>
				<?php $cnt += 1; ?>
				<?php if ($cnt == $key) break; ?>
			<?php endfor; ?>
			</div>
			<div class="clear"></div>
		<?php endfor;?>						
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('footer'); ?>