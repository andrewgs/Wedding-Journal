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
?>  
	<script type="text/javascript"> 
		$(function(){
			$("div.blog-content").each(function(){
				$(this).parents("div.blog-center:first").css('height', $(this).height()+10);
			});
		});
	</script> 	
</head>
<body>
	<div id="main-wrap">
		<div id="header">
			<div class="container_16">
				<div id="logo" class="grid_4 suffix_5">
					<a href="<? echo $pagevalue['baseurl'].'admin/login'; ?>">Авторизация</a>
				</div>
				<div class="grid_7"></div>	
			</div>
			<div class="clear"></div>
		</div>
		<div class="container_12">
			<div id="internal_nav" class="grid_4 suffix_8">
				<a href="<?php echo $pagevalue['baseurl'].$pagevalue['backpath']; ?>">&nbsp;&larr;&nbsp; Отменить авторизацию</a>
			</div>
		</div>
		<div class="clear"></div>
		<div class="container_16">
			<div id="comment-form-content" class="grid_6 form-content">
			<?php echo form_open('admin/login'); ?>
				<div id="edit-name-wrapper" class="form-item">
					<div class="grid_8">
					<?php if($msg['status'] == 1):
							echo '<div class="message">';
							echo $msg['message'].'<br/>'.$msg['error'];
							echo '</div>';
							echo '<div class="clear"></div>';
						endif; ?>
					</div>
					<div class="clear"></div>
					<?php echo form_label('Имя учетной записи: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-name'); ?>
					<?php $attr = array(
								'name' 		=> 'login',
								'id'   		=> 'usrlogin',
								'value'		=> '',
								'maxlength'	=> '60',
								'size'		=> '40',
								'class'		=> 'form-text required'
							); ?>
					<?php echo form_input($attr); ?>
				</div>
				<div id="edit-mail-wrapper" class="form-item">
				<?php echo form_label('Пароль: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-mail'); ?>
				<?php $attr = array(
							'name' 		=> 'password',
							'id'   		=> 'usrpassword',
							'value'		=> '',
							'maxlength'	=> '60',
							'size' 		=> '40',
							'class' 	=> 'form-text required'
						); ?>
				<?php echo form_password($attr); ?>
				</div>
				<?php $attr =array(
							'name' 		=> 'btsabmit',
							'id'   		=> 'btsabmit',
							'value'		=> 'Авторизоваться',
							'class' 	=> 'senden'
						); ?>
				<?php echo form_submit($attr);?>
			<?php echo form_close(); ?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php $this->load->view('footer'); ?>