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
			$('a.delete').confirm();
		});
	</script>  
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('admin/header-admin',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_6">
					<a href="<?php echo $pagevalue['baseurl'].'admin/album-new'; ?>">Создать новый альбом &nbsp;&rarr;</a>
				</div>
				<div class="clear"></div>
				<?php if($msg['status'] == 1):
					echo '<div class="message">';
						echo $msg['saccessfull'].'<br/>';
						echo $msg['message'].'<br/>'.$msg['error'];
					echo '</div>';
					echo '<div class="clear"></div>';
				endif; ?>
			</div>
			<div class="container_12">
		<?php if(count($albums)): ?>
				<div id="photo-gallery" class="container_12">
			<?php for($i = 0;$i < count($albums);$i++): ?>
					<div class="grid_5 photo-album">
						<div class="album-background">
						<?php $text='<img class="album-main-photo" src="'.$pagevalue['baseurl'].'album/viewimage/'.$albums[$i]['alb_id'].'"
									alt="'.$albums[$i]['alb_photo_title'].'"/>'; ?>
						<?php $str_uri = 'admin/photo-gallary/'.$albums[$i]['alb_id']; ?>
						<?php echo anchor($str_uri,$text); ?>
						</div>
						<div class="album-text"> 
							<div class="album-title"><?php echo $albums[$i]['alb_title']; ?></div>
							<div class="album-amt"><?php echo 'Кадров - '.$albums[$i]['alb_amt']; ?></div>
							<div class="album-annotation"><?php echo $albums[$i]['alb_annotation']; ?></div>
						</div>
						<div class="album-controls">
							<?php
								$text 		= 'Редактировать';
								$str_uri 	= 'admin/album-edit/'.$albums[$i]['alb_id'];
								echo anchor($str_uri,$text);
								$text 		= 'Удалить';
								$str_uri 	= 'admin/album-destroy/'.$albums[$i]['alb_id'];
								$attr 		= array('class'=>'delete');
								echo anchor($str_uri,$text,$attr);
							?>
						</div>
						<div class="clear"></div>
					</div>
			<?php endfor; ?>
				</div>
		<?php endif; ?>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view('footer'); ?>