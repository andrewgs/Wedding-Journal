<?php echo form_open($formaction);?>
	<div class="post-header">
		<div class="post-title">
			<?= form_label('Оглавление','eventlabel');
			$attr = array(
						'name' 		=> 'title',
						'id'   		=> 'eventtitle',
						'class'		=> 'textfield',
						'value'		=> set_value('title'),
						'maxlength'	=> '200',
						'size' 		=> '40',
					); ?>
			<?= form_input($attr); ?>
			<div>
			<?= form_label('Дата создания','eventlabel');    
						$attr = array(
						'name' 		=> 'date',
						'id'   		=> 'event-date',
						'value'		=> set_value('date'),
						'maxlength'	=> '20',
						'size' 		=> '10',
						'readonly' 	=> TRUE
					); ?> 
				<?= form_input($attr); ?>
			</div>
		</div>
	</div>
	<div class="text">
		<div class="post-title">
			<?= form_label('Содержание','eventlabel'); ?>
		</div>
		<?php $attr =array(
					'name' 	=> 'text',
					'id'   	=> 'eventtext',
					'value'	=> set_value('text'),
					'cols'	=> '81',
					'rows' 	=> '10'
				); ?>
		<div><?= form_textarea($attr); ?></div>
		<?php $attr =array(
					'name' 	=> 'btnsubmit',
					'id'   	=> 'btnsubmit',
					'class' => 'senden',
					'value'	=> 'Добавить запись'
				);
			echo form_submit($attr);?>
	<?php echo form_close(); ?>
</div>