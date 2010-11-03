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
?>
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('admin/header-admin',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
				<div class="grid_6">
					<div id="internal_nav" class="grid_4 suffix_8">
						<a href="<?php echo $pagevalue['baseurl'].'admin/events'; ?>">Управление событиями &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_8">
						<a href="<?php echo $pagevalue['baseurl'].'admin/comments'; ?>">Cписок комментариев &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_8">
						<a href="<?php echo $pagevalue['baseurl'].'admin/album-gallary'; ?>">Управление альбомами &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_8">
						<a href="<?php echo $pagevalue['baseurl'].'admin/friends'; ?>">Карточки друзей &nbsp;&rarr;</a>
					</div>
				</div>
				<div class="grid_6">
					<div id="internal_nav" class="grid_4 suffix_8">
						<a href="<?php echo $pagevalue['baseurl'].'admin/profile'; ?>">Смена пароля &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_8">
						<a href="<?php echo $pagevalue['baseurl']; ?>">На главную страницу &nbsp;&rarr;</a>
					</div>
				</div>
				<div class="clear"></div>
				<?php if($msg['status'] == 1):
					echo '<div class="message">';
					echo $msg['saccessfull'].'<br/>';
					echo $msg['message'].'<br/>'.$msg['error'];
					echo '</div>';
					echo '<div class="clear"></div>';
				endif; ?>
				<?php echo form_fieldset('Быстрый вызов функций',array('class'=>'fieldset')); ?>
					<div class="grid_12">
						<div id="internal_nav" class="grid_4">
							<a href="<?php echo $pagevalue['baseurl'].'admin/event-new'; ?>">Создать новое событие &nbsp;&rarr;</a>
						</div>
						<div id="internal_nav" class="grid_4">
							<a href="<?php echo $pagevalue['baseurl'].'admin/album-new'; ?>">Создать новый альбом &nbsp;&rarr;</a>
						</div>
						<div id="internal_nav" class="grid_3">
							<a href="<?php echo $pagevalue['baseurl'].'admin/friend-new'; ?>">Создать карточку друга &nbsp;&rarr;</a>
						</div>
					</div>
					<div class="clear"></div>
				<?php echo form_fieldset_close(); ?>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view('footer'); ?>