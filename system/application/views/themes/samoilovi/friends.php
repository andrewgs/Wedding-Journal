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
		<?php $this->load->view($themeurl.'/header'); ?>
		<div id="content">
			<?php for($i = 0,$cnt = 0;$i < $key/3;$i++): ?>	
			<div class="container_16 friend-vcards">
			<?php for($y = 0;$y < 3;$y++): ?>	
				<div class="grid_5 vcard">
					<div class="friend-info left">
					<?= '<img src="'.$baseurl.$site.'/friend/viewimage/'.$friendcard[$i][$y]['id'].'" alt=""/>'; ?>
					</div>
					<div class="friend-specs left">
						<div class="friend-name">
							<?= $friendcard[$i][$y]['name']; ?>
						</div>
						<div class="friend-profession">
							<?= $friendcard[$i][$y]['profession']; ?>
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
					<?= $friendcard[$i][$y]['note'];?>
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
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>