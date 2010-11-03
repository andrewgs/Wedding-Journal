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
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.maxlength-min.js"></script>'.CRLT;
?>
	<script type="text/javascript"> 
		$(document).ready(function(){
			$("div.blog-content").each(function(){$(this).parents("div.blog-center:first").css('height',$(this).height()+15);});
			$('#friendnote').maxlength({
				maxCharacters		: 245,
				status				: true,
				statusClass			: "lenghtstatus",
				statusText			: " символов осталось.",
				notificationClass	: "lenghtnotifi",
				slider				: true
			});
		});
	</script>	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('admin/header-admin',array('pagevalue'=>$pagevalue)); ?>
		<div class="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?php echo $pagevalue['baseurl'].$pagevalue['backpath']; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
			</div>
			<div class="clear"></div>
			<div class="container_16">
				<?php echo form_error('name').'<div class="clear"></div>'; ?>
				<?php echo form_error('profession').'<div class="clear"></div>'; ?>
				<?php echo form_error('userfile').'<div class="clear"></div>'; ?>
				<?php echo form_error('note').'<div class="clear"></div>'; ?>
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
						<?php echo form_open_multipart('admin/friend-new'); ?>
							<div class="post-header-friend">
								<div class="post-title">
								<?php echo '<div>'.form_label('Имя друга: &nbsp;&nbsp;','friendlabel'); ?>
								<?php $attr = array(
										'name' 		=> 'name',
              							'id'   		=> 'friendname',
              							'value'		=> set_value('name'),
										'class'		=> 'textfield',
              							'maxlength'	=> '40',
              							'size' 		=> '25'
									); 
									echo form_input($attr).'</div>'; ?>
								<?php echo '<div>'.form_label('Профессия: ','friendlabel'); ?>
								<?php $attr = array(
										'name' 		=> 'profession',
              							'id'   		=> 'friendprof',
              							'value'		=> set_value('profession'),
										'class'		=> 'textfield',
              							'maxlength'	=> '50',
              							'size' 		=> '25'
									);
									echo form_input($attr); ?>
								<?php echo form_label('Фото: ','friendlabel'); ?>
								<?php $attr = array(
										'type'		=> 'file',
										'name'		=> 'userfile',
										'id'		=> 'uploadimage',
										'accept'	=> 'image/jpeg,png,gif',
									);
									echo form_input($attr).'</div>';?>
								</div>
							</div>
							<div class="post-header-friend">
								<div class="post-title">
								<?php echo '<div>'.form_label('Соц.сеть:  ','friendlabel'); ?>
								<?php $attr = array(
										'name'		=> 'social1',
              							'id'   		=> 'friendsocial1',
              							'value'		=> set_value('social1'),
										'class'		=> 'textfield',
              							'maxlength'	=> '40',
              							'size' 		=> '25'
									);
									echo form_input($attr); ?>
								<?php echo form_label('Ссылка:  ','friendlabel'); ?>
								<?php $attr = array(
										'name' 		=> 'hrefsocial1',
              							'id'   		=> 'friendhrefsoc1',
              							'value'		=> set_value('hrefsocial1'),
										'class'		=> 'textfield',
              							'maxlength'	=> '50',
              							'size' 		=> '40'
									);
									echo form_input($attr).'</div>'; ?>
								<?php echo '<div>'.form_label('Соц.сеть:  ','friendlabel'); ?>
								<?php $attr = array(
										'name' 		=> 'social2',
              							'id'   		=> 'friendsocial2',
              							'value'		=> set_value('social2'),
										'class'		=> 'textfield',
              							'maxlength'	=> '40',
              							'size' 		=> '25'
									);
									echo form_input($attr); ?>
								<?php echo form_label('Ссылка:  ','friendlabel'); ?>
								<?php $attr = array(
										'name' 		=> 'hrefsocial2',
              							'id'   		=> 'friendhrefsoc2',
              							'value'		=> set_value('hrefsocial2'),
										'class'		=> 'textfield',
              							'maxlength'	=> '50',
              							'size' 		=> '40'
									);
									echo form_input($attr).'</div>'; ?>
								</div>
							</div>
							<div class="text">
								<div class="post-title">
								<?php echo form_label('Описание друга:  ','friendlabel');?>
								</div>
								<?php $attr =array(
										'name' 		=> 'note',
              							'id'   		=> 'friendnote',
              							'value'		=> set_value('note'),
										'class'		=> 'textfield',
              							'cols'		=> '81',
              							'rows' 		=> '6',
									);
									echo '<div>'.form_textarea($attr).'</div>'; ?>
								<?php $attr =array(
										'name' 	=> 'btnsubmit',
										'id'   	=> 'btnsubmit',
										'class' => 'senden',
										'value'	=> 'Создать запись'
									);
									echo form_submit($attr); ?>
							<?php echo form_close(); ?>
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
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view('footer'); ?>