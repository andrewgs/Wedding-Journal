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
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17193616-1']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		$(function(){
			$("div.blog-content").each(function(){
				$(this).parents("div.blog-center:first").css('height', $(this).height()+10);
			});
		});
	</script>		
</head>
<body>
   <div id="main-wrap">
   		<?php $this->load->view('header',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?php echo $pagevalue['baseurl'].$pagevalue['backpath']; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
				<div id="internal_nav" class="grid_4">
					<a href="#comment" style="text-align:center">Оставить комментарий</a>
				</div>
			</div>
			<div class="container_16">
				<?php echo form_error('user_name').'<div class="clear"></div>'; ?>
				<?php echo form_error('user_email').'<div class="clear"></div>'; ?>
				<?php echo form_error('cmnt_text').'<div class="clear"></div>'; ?>
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
								<?php echo '<a name="blog_'.$event['evnt_id'].'"></a>'.
											$event['evnt_title'].'</div>'; ?>
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
					<div class="clear"></div>
				</div>
			</div>
			<?php for($i = 0;$i < count($comments);$i++): ?>
			<div class="container_16">
				<div class="comment grid_10">
					<?php echo '<span class="user" id="'.$comments[$i]['cmnt_id'].'">';?>
					<?php if(!empty($comments[$i]['cmnt_web'])): ?>
						<?php echo '<a title="" target="_blank" href="'.
									$comments[$i]['cmnt_web'].'">'.$comments[$i]['cmnt_usr_name'].
									'</a></span>'; ?>
					<?php else: ?>
						<?php echo $comments[$i]['cmnt_usr_name'].'</span>'; ?>	
					<?php endif; ?>												
					<?php echo '<span class="dates">'.$comments[$i]['cmnt_usr_date'].'</span>'; ?>
					<?php echo '<p>'.$comments[$i]['cmnt_text'].'</p>';?>
					<div class="clear"></div>
				</div>			
			</div>
			<?php endfor; ?>
			<div class="container_16">
				<div id="comment-form-content" class="grid_10 form-content">
				<a name="comment"></a>
				<?php echo form_open($pagevalue['formuri']); ?>
				<?php echo form_hidden('event_id',$this->uri->segment(2)); ?>
					<div id="edit-name-wrapper" class="form-item">
					<?php echo form_label('Ваше имя: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-name');
							$attr = array(
								'name' 		=> 'user_name',
								'id'   		=> 'username',
								'value'		=> set_value('user_name'),
								'maxlength'	=> '60',
								'size' 		=> '30',
								'class' 	=> 'form-text required'
							);
							if ($pagevalue['admin'])
								$attr['value'] = $user['firstname'].' '.$user['secondname']; ?>
					<?php	echo form_input($attr);	?>
							</div>
							<div id="edit-mail-wrapper" class="form-item">
					<?php echo form_label('E-mail: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-mail');
							$attr = array(
								'name' 		=> 'user_email',
								'id'   		=> 'useremail',
								'value'		=> set_value('user_email'),
								'maxlength'	=> '255',
								'size' 		=> '30',
								'class' 	=> 'form-text required'
							);
							if ($pagevalue['admin'])
								$attr['value'] = $user['email']; ?>
					<?php	echo form_input($attr);	?>
							<div class="description">
								Содержимое данного поля сохранится в нашей базе данных 
								и не будет выводиться на экран.
							</div>
						</div>
						<div id="edit-homepage-wrapper" class="form-item">
						<?php echo form_label('Веб-сайт:','edit-homepage');
							$attr = array(
								'name' 		=> 'homepage',
								'id'   		=> 'edit-homepage',
								'value'		=> set_value('homepage'),
								'maxlength'	=> '255',
								'size' 		=> '30',
								'class' 	=> 'form-text'
							);
							if ($pagevalue['admin'])
								$attr['value'] = 'http://realitygroup.ru/'; ?>
					<?php echo form_input($attr);?>
						</div>
						<div id="edit-comment-wrapper" class="form-item">
						<?php echo form_label('Комментарий: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-comment');?>														
							<div class="resizable-textarea">
								<span>
								<?php $attr =array(
										'name'	=> 'cmnt_text',
										'id'  	=> 'cmnttext',
										'value'	=> set_value('cmnt_text'),
										'cols'	=> '60',
										'rows' 	=> '15',
										'class' => 'form-textarea resizable required textarea-processed'
									);
									echo form_textarea($attr); ?>										
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
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view('footer'); ?>