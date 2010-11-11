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
		
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.min.js"></script>';
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.confirm.js"></script>';
?> 
	<script type="text/javascript"> 
		$(document).ready(function(){
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
					<a href="<?php echo $pagevalue['baseurl'].$pagevalue['backpath']; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
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
			<?php for($i = 0; $i < count($comments);$i++): ?>
			<div class="container_16">
				<div class="comment grid_10">
					<a name="comment_<?php echo $comments[$i]['cmnt_id'];?>"></a>
				<?php
					echo '<div class="post-date">'.$comments[$i]['evnt_title'];
					echo '&nbsp;&nbsp;'.$comments[$i]['evnt_date'].'</div>';
					echo '<hr />';
					echo '<p><span class="user" id="'.$comments[$i]['cmnt_id'].'">';
					if (!empty($comments[$i]['cmnt_web']))
						echo '<a title="" target="_blank" href="'.$comments[$i]['cmnt_web'].'">'.$comments[$i]['cmnt_usr_name'].'</a></span>';
					else
						echo $comments[$i]['cmnt_usr_name'].'</span>';	
					echo '<span class="dates">&nbsp;'.$comments[$i]['cmnt_usr_date'].'</span></p>';
					echo '<p>'.$comments[$i]['cmnt_text'].'</p>';
					$text = 'Редактировать';
					$str_uri = 'admin/comment-edit/'.$comments[$i]['cmnt_evnt_id'].'/'.$comments[$i]['cmnt_id'];
					echo '<div>'.anchor($str_uri,$text).' | ';
					$text = 'Удалить';
					$str_uri = 'admin/comment-destroy/'.$comments[$i]['cmnt_evnt_id'].'/'.$comments[$i]['cmnt_id'];
					$attr = array('class'=>'delete');
					echo anchor($str_uri,$text,$attr).'</div>';
				?>
				</div>
				<div class="clear"></div>			
			</div>
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