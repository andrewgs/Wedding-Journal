<?php if($valid):
	$title 	= set_value('title');
	$date 	= set_value('date');
	$text 	= set_value('text');
else:
	$title 	= $event['evnt_title'];
	$date 	= $event['evnt_date'];
	$text 	= $event['evnt_text'];
endif; ?>
<?php echo form_open($formaction);?>
	<div class="post-header">
		<div class="post-title">
			<?php if($edit): ?>
				<?= form_hidden('id',$event['evnt_id']); ?>
				<?= form_hidden('cnt',$event['evnt_cnt_cmnt']); ?>
			<?php endif; ?>
			<?= form_label('Оглавление','eventlabel');
			$attr = array(
						'name' 		=> 'title',
						'id'   		=> 'eventtitle',
						'class'		=> 'textfield',
						'value'		=> $title,
						'maxlength'	=> '200',
						'size' 		=> '40',
					); ?>
			<?= form_input($attr); ?>
			<div>
			<?= form_label('Дата создания','eventlabel');    
						$attr = array(
						'name' 		=> 'date',
						'id'   		=> 'event-date',
						'value'		=> $date,
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
					'value'	=> $text,
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