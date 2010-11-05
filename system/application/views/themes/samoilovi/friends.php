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
		(function(){
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
				<?php if($admin): ?>
					<div id="internal_nav" class="grid_4">
						<a href="<?= $baseurl.$usite.'/friend-new'; ?>">Создать карточку друга &nbsp;&rarr;</a>
					</div>
				<?php endif; ?>
				<div class="clear"></div>
				<?php $this->load->view('message');?>
			</div>	
			<?php for($i = 0,$cnt = 0;$i < $key/3;$i++): ?>	
			<div class="container_16 friend-vcards">
			<?php for($y = 0;$y < 3;$y++): ?>	
				<div class="grid_5 vcard">
					<div class="friend-info left">
					<?= '<img src="'.$baseurl.$usite.'/friend/viewimage/'.$friend[$i][$y]['id'].'" alt=""/>'; ?>
					</div>
					<div class="friend-specs left">
						<div class="friend-name">
							<?= $friend[$i][$y]['name']; ?>
						</div>
						<div class="friend-profession">
							<?= $friend[$i][$y]['profession']; ?>
						</div>
					<?php if($friend[$i][$y]['social'] != 0):?>
							<div class="friend-social">
							<?php for($soc = 0;$soc < count($social); $soc++):
								if ($social[$soc]['soc_fr_id'] == $friend[$i][$y]['id'])	
									echo anchor($social[$soc]['soc_href'],$social[$soc]['soc_name'],array('target'=>'_blank')).'&nbsp;';
							endfor; ?>
							</div>
					<?php endif; ?>						
						<hr/>
					</div>
					<div class="clear"></div>
					<div class="friend-note">
					<?= $friend[$i][$y]['note'];?>
					</div>
					<?php if($admin): ?>
						<div class="friend-controls">
							<?php $text = 'Редактировать'; ?>
							<?php $str_uri = $usite.'/friend-edit/'.$friend[$i][$y]['id'];?>
							<?= anchor($str_uri,$text); ?>
							<?php $text = ' Удалить'; ?>
							<?php $str_uri = $usite.'/friend-destroy/'.$friend[$i][$y]['id']; ?>
							<?php $attr = array('class'=>'delete'); ?>
							<?= anchor($str_uri,$text,$attr); ?>
						</div>
					<?php endif; ?>
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