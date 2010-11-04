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
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		$(function(){
			$("div.blog-content").each(function(){
				$(this).parents("div.blog-center:first").css('height',$(this).height()+10);
			});
		});
	</script>	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/header'); ?>
		<div id="content">
			<?php if(isset($pages) and !empty($pages)): ?>
				<div class="container_12">
					<div class="grid_3 omega">
						<div class='pagination'><?= $pages; ?></div>
					</div>
				</div>
				<div class="clear"></div>
			<?php endif; ?>
			<?php for($i = 0; $i < count($events);$i++): ?>
			<div class="container_16">
				<div id="blog" class="grid_16">
					<div class="blog-top"> 
						<div class="blog-tl"> </div>
						<div class="blog-t"> </div>
						<div class="blog-tr"> </div>
						<div class="clear"></div>
					</div>
					<div class="blog-center"> 
						<div class="blog-l"> </div>
						<div class="blog-content">
							<div class="post-header">
								<div class="post-title">
								<?= '<a name="event_'.$events[$i]['evnt_id'].'"></a>'.$events[$i]['evnt_title']; ?>
								</div>
								<div class="post-date">
									<?= $events[$i]['evnt_date']; ?>
								</div>
							</div>
							<div class="text">
								<?= $events[$i]['evnt_text']; ?>
								<div class="cnt_comments">
									<?php $text = $events[$i]['evnt_cnt_cmnt'].' комментариев &raquo;'; ?>
									<?php $link = $usite.'/event/'.$events[$i]['evnt_id']; ?>
									<?= anchor($link,$text); ?>
								</div>
							</div>
						</div>
						<div class="blog-r"> </div>
						<div class="clear"></div>
					</div>
					<div class="blog-bottom">
						<div class="blog-bl"></div>
						<div class="blog-b"></div>
						<div class="blog-br"></div>						
					 </div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		<?php endfor; ?>
		
		<?php if(isset($pages) and !empty($pages)): ?>
			<div class="container_12">
				<div class="grid_3 omega">
					<div class='pagination'><?= $pages; ?></div>
				</div>
			</div>
			<div class="clear"></div>
		<?php endif; ?>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>