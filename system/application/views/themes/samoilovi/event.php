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
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		$(function(){
			$("div.blog-content").each(function(){
				$(this).parents("div.blog-center:first").css('height',$(this).height()+10);
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
				<div id="internal_nav" class="grid_4">
					<a href="#comment" style="text-align:center">Оставить комментарий</a>
				</div>
				<?php $this->load->view('message');?>
			</div>
			<div class="clear"></div>
			<div class="container_16">
				<?= form_error('user_name'); ?>
				<?= form_error('user_email'); ?>
				<?= form_error('cmnt_text'); ?>
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
									<a name="blog_<?= $event['evnt_id'];?>"></a>
									<?= $event['evnt_title']; ?>
								</div>
								<div class="post-date">
									<?= $event['evnt_date']; ?>
								</div>
							</div>
							<div class="text">
								<?= $event['evnt_text']; ?>
								<br />
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
			<?php for($i = 0;$i < count($comments);$i++): ?>
			<div class="container_16">
				<div class="comment grid_12">
					<a name="comment_<?= $comments[$i]['cmnt_id'];?>"></a>
					<span class="user" id="<?= $comments[$i]['cmnt_id'];?>">
					<?php if(!empty($comments[$i]['cmnt_web'])): ?>
						<a title="" target="_blank" href="<?= $comments[$i]['cmnt_web'];?>"><?= $comments[$i]['cmnt_usr_name'];?></a>
					<?php else: ?>
						<?= $comments[$i]['cmnt_usr_name']; ?>	
					<?php endif; ?>
					</span>
					<span class="dates"><?= $comments[$i]['cmnt_usr_date'];?></span>
					<p><?= $comments[$i]['cmnt_text']; ?></p>
					<div class="clear"></div>
					<?php if($admin): ?>
						<div>
							<?php $text = 'Редактировать'; ?>
							<?php $link = $usite.'/comment-edit/'.$comments[$i]['cmnt_evnt_id'].'/'.$comments[$i]['cmnt_id']; ?>
							<?= anchor($link,$text).' | '; ?>
							<?php $text = 'Удалить'; ?>
							<?php $link = $usite.'/comment-destroy/'.$comments[$i]['cmnt_evnt_id'].'/'.$comments[$i]['cmnt_id']; ?>
							<?php $attr = array('class'=>'delete'); ?>
							<?= anchor($link,$text,$attr); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endfor; ?>
			<div class="container_16">
				<div id="comment-form-content" class="grid_10 form-content">
				<a name="comment"></a>
					<?php $this->load->view('forms/frmcomment');?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>