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
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/datepicker/jquery.ui.all.css" type="text/css" />'.CRLT;
		
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/datepicker/jquery-1.4.2.js"></script>';
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/datepicker/jquery.bgiframe-2.1.1.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/datepicker/jquery.ui.core.js"></script>';
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/datepicker/jquery.ui.datepicker-ru.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/datepicker/jquery.ui.datepicker.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/datepicker/jquery.ui.widget.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'ckeditor/ckeditor.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'ckeditor/adapters/jquery.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'ckfinder/ckfinder.js"></script>'.CRLT;
?>
	<script type="text/javascript">
		$(document).ready(function(){
				var config = {
					skin : 'v2',
					removePlugins : 'scayt',
					resize_enabled: false,
					height: '200px',
					toolbar:
					[
						['Source','-','Preview','-','Templates'],
						['Cut','Copy','Paste','PasteText'],
						['Undo','Redo','-','SelectAll','RemoveFormat'],
						'/',
						['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
						['NumberedList','BulletedList','-','Outdent','Indent'],
						['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
						['Link','Unlink'],
						'/',
						['Format','-'],
						['Image','Table','HorizontalRule','SpecialChar','-'],
						['Maximize', 'ShowBlocks']
					]
				};
	
				$('textarea#cmnttext').ckeditor(config);
				var editor = $('textarea#cmnttext').ckeditorGet();
	
				CKFinder.setupCKEditor(editor,"<?php echo $pagevalue['baseurl'].'ckfinder/'; ?>") ;
				$("input#userdate").datepicker($.datepicker.regional['ru']);
				$("div.blog-content").each(function(){
					$(this).parents("div.blog-center:first").css('height', $(this).height()+150);
				});
		});
	</script>
</head>
<body>
   <div id="main-wrap">
		<?php $this->load->view('admin/header-admin',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4 suffix_8">
					<a href="<?php echo $pagevalue['baseurl'].$pagevalue['backpath']; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
			</div>
			<div class="container_16">
				<?php echo form_error('user_name').'<div class="clear"></div>'; ?>
				<?php echo form_error('user_email').'<div class="clear"></div>'; ?>
				<?php echo form_error('cmnt_text').'<div class="clear"></div>'; ?>
				<?php if($pagevalue['valid']):
					$name 	= set_value('user_name');
					$mail 	= set_value('user_email');
					$web	= set_value('homepage');
					$date	= set_value('user_date');
					$text 	= set_value('cmnt_text');
				else:
					$name 	= $comment['cmnt_usr_name'];
					$mail 	= $comment['cmnt_usr_email'];
					$web	= $comment['cmnt_web'];
					$date	= $comment['cmnt_usr_date'];
					$text 	= $comment['cmnt_text'];
				endif; ?>
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
						<?php echo form_open($pagevalue['formuri']); ?>
							<div class="post-header">
								<div class="post-title">
							<?php echo form_hidden('id',$comment['cmnt_id']); ?>
							<?php echo form_hidden('event_id',$comment['cmnt_evnt_id']); ?>
							<?php echo '<div>'.form_label('Имя: ','cmntlabel');
									$attr = array(
											'name' => 'user_name',
              								'id'   => 'username',
              								'value'=> $name,
              							'maxlength'=> '60',
              								'size' => '30'
									);
									echo form_input($attr);
									echo form_label(' E-mail: ','cmntlabel');
									$attr = array(
											'name' => 'user_email',
              								'id'   => 'useremail',
              								'value'=> $mail,
              							'maxlength'=> '64',
              								'size' => '30'
									);											
									echo form_input($attr).'</div>';
									echo '<div>'.form_label('Сайт: ','cmntlabel');
									$attr = array(
											'name' => 'homepage',
              								'id'   => 'edit-homepage',
              								'value'=> $web,
              							'maxlength'=> '100',
              								'size' => '29'
									);											
									echo form_input($attr);
									echo form_label(' Дата: &nbsp;&nbsp;','cmntlabel');
									$attr = array(
											'name' => 'user_date',
              								'id'   => 'userdate',
              								'value'=> $date,
              							'maxlength'=> '45',
              								'size' => '10',
										'readonly' => TRUE
									);
									echo form_input($attr).'</div>'; ?>
								</div>
							</div>
							<div class="text">
								<div class="post-title">
								<?php form_label('Содержимое комментария:','cmntlabel'); ?>
								</div>
							<?php $attr =array(
										'name' 	=> 'cmnt_text',
              							'id'   	=> 'cmnttext',
              							'value'	=> $text,
              							'cols'	=> '80',
              							'rows' 	=> '10'
									);
								echo '<div>'.form_textarea($attr).'</div>';
								$attr =array(
										'name' 	=> 'btnsubmit',
	              						'id'   	=> 'btnsubmit',
										'class' => 'senden',
	              						'value'	=> 'Сохранить изменения'
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