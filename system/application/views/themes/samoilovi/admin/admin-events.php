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
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.confirm.js"></script>'.CRLT;
?> 
	<script type="text/javascript"> 
		$(document).ready(function(){
				$("div.blog-content").each(function(){
					$(this).parents("div.blog-center:first").css('height', $(this).height()+10);
				});
				$('a.delete').confirm();
		});
	</script> 	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('admin/header-admin',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?php echo $pagevalue['baseurl'].'admin/event-new'; ?>">Создать новое событие &nbsp;&rarr;</a>
				</div>
				<div class="clear"></div>
			<?php if($msg['status'] == 1):
					echo '<div class="message">';
					echo $msg['saccessfull'].'<br/>';
					echo $msg['message'].'<br/>'.$msg['error'];
					echo '</div>';
					echo '<div class="clear"></div>';
				endif; ?>
				<?php if(isset($pages) and !empty($pages)): ?>
					<div class="grid_3 omega">
						<div class='pagination'><?php echo $pages; ?></div>
					</div>
					<div class="clear"></div>
				<?php endif; ?>
			</div>	
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
								<?php echo '<a name="event_'.$events[$i]['evnt_id'].'"></a>'.
											$events[$i]['evnt_title']; ?>
								</div>
								<?php echo '<div class="post-date">'.$events[$i]['evnt_date'].'</div>'; ?>
							</div>
							<div class="text">
								<?php
									echo $events[$i]['evnt_text'];
									$text = $events[$i]['evnt_cnt_cmnt'].' комментариев &raquo;';
									$str_uri = '/admin/event/'.$events[$i]['evnt_id'];
									echo '<div class="cnt_comments">'.anchor($str_uri,$text).' | ';
									$text = 'Редактировать';
									$str_uri = '/admin/event-edit/'.$events[$i]['evnt_id'];
									echo anchor($str_uri,$text).' | ';
									$text = 'Удалить';
									$str_uri = '/admin/event-destroy/'.$events[$i]['evnt_id'];
									$attr = array('class'=>'delete');
									echo anchor($str_uri,$text,$attr).'</div>';
								?>
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