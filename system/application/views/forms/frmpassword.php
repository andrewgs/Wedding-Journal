<?= form_open($formaction); ?>
	<div id="edit-name-wrapper" class="form-item">
		<?php $attr = array('name'=>'','id'=>'','class'=>'form-text required','value'=>'','maxlength'=>'70','size'=>'40'); ?>
		<?= form_label('Старый пароль:','userlabel'); ?>
		<?php $attr['name']		= 'oldpass'; ?>
		<?= form_password($attr); ?>
		<?= form_error('oldpass'); ?>
		<div class="clear"></div>
		<?= form_label('Новый пароль:','userlabel'); ?>
		<?php $attr['name'] 	= 'password'; ?>
		<?= form_password($attr); ?>
		<?= form_error('password'); ?>
		<div class="clear"></div>
		<?= form_label('Подтверждение пароля:','userlabel'); ?>
		<?php $attr['name'] 	= 'confirmpass'; ?>
		<?= form_password($attr); ?>
		<?= form_error('confirmpass'); ?>
		<div class="clear"></div>
		<?php $attr['name'] 	= 'btnsubmit'; ?>
		<?php $attr['value'] 	= 'Сохранить'; ?>
		<?php $attr['class'] 	= 'senden'; ?>
		<?= form_submit($attr);?>
	</div>
<?= form_close(); ?>