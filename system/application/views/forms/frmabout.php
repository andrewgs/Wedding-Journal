<?= form_open_multipart($formaction); ?>
	<div class="post-header">
		<div class="post-title">
			<?= form_label('Подпись: ','albumlabel'); ?>
			<?php $attr = array(
						'name' 		=> 'title',
						'value'		=> $image['oititle'],
						'class'		=> 'textfield',
						'maxlength'	=> '100',
						'size' 		=> '30'
					); ?>	
			<?= form_input($attr); ?>
			<div>
				<?= form_label('Фото:','about'); ?>
				<?php $attr = array(
							'type' 	   => 'file',
							'name' 	   => 'userfile',
							'id'  	   => 'uploadimage',
							'accept'   => 'image/jpeg,png,gif',
						);
				echo form_input($attr); ?>
				<?= form_label($ratio,'about'); ?>
			</div>
		</div>
	</div>
	<div class="text">
		<div class="post-title">
			<?= form_label('О нас:','about');?>
		</div>
			<?php $attr = array(
					'name' 		=> 'text',
					'class'		=> 'textfield',
					'value'		=> $text,
					'cols'		=> '81',
					'rows' 		=> '10'
				);
			echo form_textarea($attr); ?>
		<?php $attr =array(
				'name' 	=> 'btnsubmit',
				'id'   	=> 'btnsubmit',
				'class' => 'senden',
				'value'	=> 'Сохранить'
			);
		echo form_submit($attr);?>
	</div>
<?php echo form_close(); ?>