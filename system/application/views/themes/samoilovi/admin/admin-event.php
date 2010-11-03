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
		$(function(){
			$("div.blog-content").each(function(){
				$(this).parents("div.blog-center:first").css('height', $(this).height()+10);
			});
		});
		$(document).ready(function() {	
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
				<div id="internal_nav" class="grid_4">
					<a href="#comment" style="text-align:center">Оставить комментарий</a>
				</div>
				<?php if($msg['status'] == 1):
					echo '<div class="message">';
					echo $msg['saccessfull'].'<br/>';
					echo $msg['message'].'<br/>'.$msg['error'];
					echo '</div>';
				endif; ?>
				<div class="clear"></div>
			</div>
			<div class="container_16">
				<?php echo form_error('user_name').'<div class="clear"></div>'; ?>
				<?php echo form_error('user_email').'<div class="clear"></div>'; ?>
				<?php echo form_error('cmnt_text').'<div class="clear"></div>'; ?>
				<div id="blog" class="grid_12">
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
								<?php echo '<a name="blog_'.$event['evnt_id'].'"></a>'.	$event['evnt_title']; ?>
								</div>
								<?php echo '<div class="post-date">'.$event['evnt_date'].'</div>'; ?>
							</div>
							<div class="text">
								<?php echo $event['evnt_text'].'<br />'; ?>
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
				<div class="clear"></div>
			</div>
			<?php for($i = 0;$i < count($comments);$i++): ?>
			<div class="container_16">
				<div class="comment grid_12">
					<a name="comment_<?php echo $comments[$i]['cmnt_id'];?>"></a>
					<?php
						echo '<span class="user" id="'.$comments[$i]['cmnt_id'].'">';
						if (!empty($comments[$i]['cmnt_web'])):
							echo '<a title="" target="_blank" href="'.$comments[$i]['cmnt_web'].'">'.
									$comments[$i]['cmnt_usr_name'].'</a></span>';
						else:
							echo $comments[$i]['cmnt_usr_name'].'</span>';	
						endif;
						echo '<span class="dates">'.$comments[$i]['cmnt_usr_date'].'</span>';
						echo '<p>'.$comments[$i]['cmnt_text'].'</p>';
						$text = 'Редактировать';
						$link = 'admin/comment-edit/'.$comments[$i]['cmnt_evnt_id'].'/'.$comments[$i]['cmnt_id'];
						echo '<div>'.anchor($link,$text).' | ';
						$text = 'Удалить';
						$link = 'admin/comment-destroy/'.$comments[$i]['cmnt_evnt_id'].'/'.$comments[$i]['cmnt_id'];
						$attr = array('class'=>'delete');
						echo anchor($link,$text,$attr).'</div>';						
					?>
				</div>
				<div class="clear"></div>			
			</div>
			<?php endfor; ?>
			<div class="container_16">
				<?php if($pagevalue['valid']):
						$name 	= set_value('user_name');
						$mail 	= set_value('user_email');
						$web	= set_value('homepage');
						$text 	= set_value('cmnt_text');
					else:
						$name 	= $user['usr_first_name'].' '.$user['usr_second_name'];
						$mail 	= $user['usr_email'];
						$web	= 'http://realitygroup.ru/';
						$text 	= '';
					endif; ?>
				<div id="comment-form-content" class="grid_10 form-content">
				<a name="comment"></a>
				<?php echo form_open($pagevalue['formuri']); ?>
				<?php echo form_hidden('event_id',$this->uri->segment(3)); ?>
					<div id="edit-name-wrapper" class="form-item">
					<?php echo form_label('Ваше имя: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-name');
							$attr = array(
								'name' 		=> 'user_name',
								'id'   		=> 'username',
								'value'		=> $name,
								'maxlength'	=> '60',
								'size' 		=> '30',
								'class' 	=> 'form-text required'
							);
							echo form_input($attr);	?>
					</div>
					<div id="edit-mail-wrapper" class="form-item">
						<?php echo form_label('E-mail: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-mail');
							$attr = array(
								'name'		=> 'user_email',
								'id'   		=> 'useremail',
								'value'		=> $mail,
								'maxlength'	=> '64',
								'size' 		=> '30',
								'class' 	=> 'form-text required'
							);
							echo form_input($attr);	?>
						<div class="description">
							Содержимое данного поля сохранится в нашей базе данных и не 
							будет выводиться на экран.
						</div>
					</div>
					<div id="edit-homepage-wrapper" class="form-item">
						<?php echo form_label('Веб-сайт:','edit-homepage');
							$attr = array(
								'name' 		=> 'homepage',
								'id'   		=> 'edit-homepage',
								'value'		=> $web,
								'maxlength'	=> '100',
								'size' 		=> '30',
								'class' 	=> 'form-text'
							);
							echo form_input($attr);	?>
					</div>
					<div id="edit-comment-wrapper" class="form-item">
						<?php echo form_label('Комментарий: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-comment'); ?>														
						<div class="resizable-textarea">
							<span>
							<?php $attr =array(
									'name' 	=> 'cmnt_text',
									'id'   	=> 'cmnttext',
									'value'	=> $text,
									'cols'	=> '60',
									'rows' 	=> '15',
									'class' => 'form-textarea resizable required textarea-processed'
								);
								echo form_textarea($attr);	?>
							</span>
						</div>
					</div>
					<?php $attr =array(
							'name' 	=> 'op',
							'id'   	=> 'ajax-comments-submit',
							'value'	=> 'Добавить комментарий',
							'class' => 'senden'
						);
						echo form_submit($attr); ?>
					<?php echo form_close(); ?>
				</div>
				<div class="clear"></div>
			</div>			
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view('footer'); ?>