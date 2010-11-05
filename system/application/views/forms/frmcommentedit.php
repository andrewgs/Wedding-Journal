<?php if($valid):
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
<?= form_open($formaction); ?>
	<div class="post-header">
		<div class="post-title">
			<?= form_hidden('id',$comment['cmnt_id']); ?>
			<?= form_hidden('event_id',$comment['cmnt_evnt_id']); ?>
			<?= form_label('Имя: ','cmntlabel');
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
			echo form_input($attr); ?>
			<div>
				<?= form_label('Сайт: ','cmntlabel');
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
				echo form_input($attr); ?>
			</div>	
		</div>
	</div>
	<div class="text">
		<div class="post-title">
			<?= form_label('Содержимое комментария:','cmntlabel'); ?>
		</div>
		<?php $attr =array(
					'name' 	=> 'cmnt_text',
            		'id'   	=> 'cmnttext',
            		'value'	=> $text,
            		'cols'	=> '80',
            		'rows' 	=> '10'
				); ?>
		<div><?= form_textarea($attr); ?></div>
		<?php $attr =array(
					'name' 	=> 'btnsubmit',
	        		'id'   	=> 'btnsubmit',
					'class' => 'senden',
	            	'value'	=> 'Сохранить изменения'
				);
		echo form_submit($attr); ?>
	</div>
<?php echo form_close(); ?>
	