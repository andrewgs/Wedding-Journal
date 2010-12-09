<?php if($valid):
	$title 	= set_value('title');
	$text 	= set_value('text');
else:
	$title 	= $pagetext['title'];
	$text 	= $pagetext['text'];
endif; ?>
<?php echo form_open($formaction);?>
	<div class="post-header">
		<div class="post-title">
			<?= form_label('Подпись','indextitle');
			$attr = array(
						'name' 		=> 'title',
						'id'   		=> 'indextitle',
						'class'		=> 'textfield',
						'value'		=> $title,
						'maxlength'	=> '200',
						'size' 		=> '40',
					); ?>
			<?= form_input($attr); ?>
		</div>
	</div>
	<div class="text">
		<div class="post-title">
			<?= form_label('Содержание','indextitle'); ?>
		</div>
		<?php $attr =array(
					'name' 	=> 'text',
					'id'   	=> 'indextext',
					'class'	=> 'textfield',
					'value'	=> $text,
					'cols'	=> '65',
					'rows' 	=> '8'
				); ?>
		<?= form_textarea($attr); ?>
		<?php $attr =array(
					'name' 	=> 'btnsubmit',
					'id'   	=> 'btnsubmit',
					'class' => 'senden',
					'value'	=> 'Сохранить'
				);
			echo form_submit($attr);?>
	<?php echo form_close(); ?>
</div>