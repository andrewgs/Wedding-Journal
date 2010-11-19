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
		$(document).ready(function(){
			$('a.delete').confirm();
		});
	</script>	
</head>
<body>
   <div id="main-wrap">
		<?php $this->load->view($themeurl.'/admin/header-admin'); ?>
		<div id="content">
			<?php $this->load->view('transitions/fullback');?>
			<div class="container_12">
				<?php $this->load->view('message');?>
				<?php if(isset($pages) and !empty($pages)): ?>
					<div class="grid_3 omega">
						<div class='pagination'><?= $pages; ?></div>
					</div>
					<div class="clear"></div>
				<?php endif; ?>
			</div>	
			<?php for($i = 0; $i < count($comments);$i++): ?>
			<div class="container_16">
				<div class="comment grid_10">
					<div class="post-date">
						<?= $comments[$i]['evnt_title'];?>
						&nbsp;&nbsp;
						<?= $comments[$i]['evnt_date']; ?>
					</div>
					<hr />
					<p><span class="user" id="<?= $comments[$i]['cmnt_id']; ?>">
					<?php if(!empty($comments[$i]['cmnt_web'])): ?>
						<a title="" target="_blank" href="<?= $comments[$i]['cmnt_web']; ?>"><?= $comments[$i]['cmnt_usr_name']; ?></a>
					<?php else: ?>
						<?= $comments[$i]['cmnt_usr_name']; ?>
					<?php endif; ?>
					</span>	
					<span class="dates">&nbsp;<?= $comments[$i]['cmnt_usr_date']; ?></span></p>
					<p><?= $comments[$i]['cmnt_text']; ?> </p>
					<div>
						<?php $text = 'Редактировать'; ?>
						<?php $link = $usite.'/comment-edit/'.$comments[$i]['cmnt_evnt_id'].'/'.$comments[$i]['cmnt_id']; ?>
						<?= anchor($link,$text).' | '; ?>
						<?php $text = 'Удалить'; ?>
						<?php $link = $usite.'/comment-destroy/'.$comments[$i]['cmnt_evnt_id'].'/'.$comments[$i]['cmnt_id']; ?>
						<?php $attr = array('class'=>'delete'); ?>
						<?= anchor($link,$text,$attr); ?>
					</div>
				</div>
				<div class="clear"></div>			
			</div>
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