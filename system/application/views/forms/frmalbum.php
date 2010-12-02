<?php if($valid):
	$title 			= set_value('title');
	$photo_title 	= set_value('photo_title');
	$annotation 	= set_value('annotation');
else:
	$title 			= $album['alb_title'];
	$photo_title 	= $album['alb_photo_title'];
	$annotation 	= $album['alb_annotation'];
endif; ?>
<?= form_open_multipart($formaction); ?>
	<div class="post-header">
		<div class="post-title">
			<?php if($edit): ?>
				<?= form_hidden('id',$album['alb_id']); ?>
				<?= form_hidden('amt',$album['alb_amt']); ?>
			<?php endif; ?>
			<?= form_label('Название альбома:','albumlabel');?>
			<?php $attr = array(
					'name' 		=> 'title',
					'id'   		=> 'albumtitle',
					'class'		=> 'textfield',
					'value'		=> $title,
					'maxlength'	=> '12',
					'size' 		=> '30'
									);
			echo form_input($attr); ?>
			<div>
				<?= form_label('Фото:','albumlabel'); ?>
				<?php $attr = array(
							'type' 	   => 'file',
							'name' 	   => 'userfile',
							'id'  	   => 'uploadimage',
							'accept'   => 'image/jpeg,png,gif',
						);
				echo form_input($attr); ?>
				<?= form_label('&nbsp; Подпись: ','albumlabel'); ?>
				<?php $attr = array(
							'name' 		=> 'photo_title',
							'id'   		=> 'photo-title',
							'value'		=> $photo_title,
							'class'		=> 'textfield',
							'maxlength'	=> '100',
							'size' 		=> '30'
						); ?>	
				<?= form_input($attr); ?>
			</div>
		</div>
	</div>
	<div class="text">
		<div class="post-title">
			<?= form_label('Описание альбома','albumlabel'); ?>
		</div>
		<?php $attr =array(
					'name' 		=> 'annotation',
					'id'   		=> 'annotation',
					'value'		=> $annotation,
					'class'		=> 'textfield',
					'cols'		=> '81',
					'rows' 		=> '5'
				);
		echo form_textarea($attr);
		$attr =array(
				'name' 	=> 'btnsubmit',
				'id'   	=> 'btnsubmit',
				'class' => 'senden',
				'value'	=> 'Сохранить'
			);
		echo form_submit($attr);?>
	</div>
<?php echo form_close(); ?>