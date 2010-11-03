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
		$(function(){
			$("div.blog-content").each(function(){
				$(this).parents("div.blog-center:first").css('height',$(this).height()+10);
			});
		});
	</script>	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('header',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<?php if(isset($pages) and !empty($pages)): ?>
				<div class="container_12">
					<div class="grid_3 omega">
						<div class='pagination'><?php echo $pages; ?></div>
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
						<?php echo '<a name="event_'.$events[$i]['evnt_id'].'"></a>'.$events[$i]['evnt_title']; ?>
								</div>
							<?php echo '<div class="post-date">'.$events[$i]['evnt_date'].'</div>'; ?>
							</div>
							<div class="text">
								<?php echo $events[$i]['evnt_text']; ?>
								<?php $text = $events[$i]['evnt_cnt_cmnt'].' комментариев &raquo;'; ?>
								<?php $link = 'event/'.$events[$i]['evnt_id']; ?>
								<?php echo '<div class="cnt_comments">'.anchor($link,$text).'</div>'; ?>
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
					<div class='pagination'><?php echo $pages; ?></div>
				</div>
			</div>
			<div class="clear"></div>
		<?php endif; ?>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('footer'); ?>