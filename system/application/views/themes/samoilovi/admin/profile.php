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
		<div class="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?php echo $pagevalue['baseurl'].$pagevalue['backpath']; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
				<div class="clear"></div>
				<?php if($msg['status'] == 1):
					echo '<div class="message">';
					echo $msg['message'].'<br/>'.$msg['error'];
					echo '</div>';
					echo '<div class="clear"></div>';
				endif; ?>
			</div>
			<div class="container_16">
				<div id="comment-form-content" class="grid_6 form-content">
				<?php echo form_open('admin/profile'); ?>
				<?php echo form_hidden('id',$userinfo['usr_id']); ?>
				<?php echo form_error('oldpass'); ?>
					<div class="clear"></div>
					<div id="edit-name-wrapper" class="form-item">
					<?php echo form_label('Старый пароль','userslabel'); ?>
					<?php $attr = array(
							'name'		=> 'oldpass',
							'id'  		=> 'oldpass',
							'value'		=> '',
							'maxlength'	=> '70',
	        				'size' 		=> '40',
							'class' 	=> 'form-text required'
						);
						echo form_password($attr); ?>
					<?php echo form_error('newpass'); ?>
					<div class="clear"></div>
					<?php echo form_label('Новый пароль','userslabel'); ?>
					<?php $attr =array(
							'name'	 	=> 'newpass',
							'id'  		=> 'newpass',
							'value'		=> '',
							'maxlength'	=> '70',
	        				'size' 		=> '40',
							'class' 	=> 'form-text required'
						);
						echo form_password($attr); ?>
					<?php echo form_error('confirmpass'); ?>
					<div class="clear"></div>
					<?php echo form_label('Подтверждение пароля','userslabel'); ?>
					<?php $attr =array(
							'name'	 	=> 'confirmpass',
							'id'  		=> 'confirmpass',
							'value'		=> '',
							'maxlength'	=> '70',
	        				'size' 		=> '40',
							'class' 	=> 'form-text required'
						);
						echo form_password($attr); ?>
					</div>
					<div class="clear"></div>
					<?php $attr =array(
							'name' 		=> 'btnsubmit',
							'id'   		=> 'btnsubmit',
							'class' 	=> 'senden',
							'value'		=> 'Создать запись'
						);
						echo form_submit($attr);?>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view('footer'); ?>