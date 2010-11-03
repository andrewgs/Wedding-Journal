<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta http-equiv="Expires" content="1 Jan 2000 0:00:00 GMT"/>
	<meta name="language" content="ru" />
    <meta name="description" content="{description}"/>
    <meta name="keywords" content="{keywords}"/>
    <title>{title}</title>
	
	<link rel="stylesheet" href="{baseurl}css/960.css" type="text/css" />
	
	<link rel="stylesheet" href="{themeurl}/css/reset.css" type="text/css" /> 
	<link rel="stylesheet" href="{themeurl}/css/style.css" type="text/css" />
	
	<script type="text/javascript" src="{baseurl}javascript/jquery.min.js"></script>
	<script type="text/javascript" src="{baseurl}javascript/swfobject.js"></script>
	<script type="text/javascript" src="{baseurl}javascript/base.js"></script>
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
	<?php if('{admin}'): ?>
		<div id="admin-panel">
			<span>Вы вошли как Администратор</span>
			&nbsp;&nbsp;<a class="logout" href="'{baseurl}admin">Управление</a>&nbsp;|
			<a class="logout" href="{baseurl}logoff">Завершить сеанс</a>
		</div>
	<?php endif; ?>
	<div id="header">
		<div class="container_16">
			<div id="logo" class="grid_4 suffix_5">
			<?php echo anchor('','<img src="{baseurl}images/logo.png" alt=""/>'); ?>
			</div>
			<div class="grid_7">
				<ul id="header-menu">
				<?php echo "<li>".anchor('{usite}/about','О нас')."</li>"; ?>
				<?php echo "<li>".anchor('{usite}/friends','Друзья')."</li>"; ?>
				<?php echo "<li>".anchor('{usite}/events','События')."</li>"; ?>
				<?php echo "<li>".anchor('{usite}/photo-albums','Фотографии')."</li>"; ?>							
				</ul>
			</div>	
		</div>
		<div class="clear"></div>
	</div>
</body>
</html>
	