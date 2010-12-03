<fieldset class="">
	<legend><strong>Критерий отбора</strong></legend>
	<?= form_open($formaction);?>
		<select name="cmntval">
			<option selected="selected" disabled value="0">Выбирите критерий</option>
			<option value="1">Комментарии к событиям</option>
			<option value="2">Комментарии к фотографиям</option>
		</select>
		<?php $attr = array('name'=>'btnsubmit','class'=>'','value'=>'Показать'); ?>
		<?= form_submit($attr); ?>
	<?= form_close(); ?>
</fieldset>