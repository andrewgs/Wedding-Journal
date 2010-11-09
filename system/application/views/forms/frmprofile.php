<?php if($valid):
	$name 			= set_value('name');
	$subname 		= set_value('subname');
	$email 			= set_value('email');
	$sitename 		= set_value('sitename');
	$weddingdate 	= set_value('weddingdate');
else:
	$name 			= $user['uname'];
	$subname 		= $user['usubname'];
	$email 			= $user['uemail'];
	$sitename 		= $user['usite'];
	$weddingdate 	= $user['uweddingdate'];
endif; ?>
<?= form_open($formaction); ?>
	<div id="edit-name-wrapper" class="form-item">
		<?php $attr = array('name'=>'','id'=>'','class'=>'form-text required','value'=>'','maxlength'=>'70','size'=>'40'); ?>
		<?= form_label('Ваше имя:','userlabel'); ?>
		<?php $attr['name']			= 'name'; ?>
		<?php $attr['value']		= $name; ?>
		<?= form_input($attr); ?>
		<?= form_error('name'); ?>
		<div class="clear"></div>
		<?= form_label('Ваша фамилия:','userlabel'); ?>
		<?php $attr['name'] 		= 'subname'; ?>
		<?php $attr['value'] 		= $subname; ?>
		<?= form_input($attr); ?>
		<?= form_error('subname'); ?>
		<div class="clear"></div>
		<?= form_label('E-mail:','userlabel'); ?>
		<?php $attr['name'] 		= 'email'; ?>
		<?php $attr['value'] 		= $email; ?>
		<?php echo form_input($attr); ?>
		<?= form_error('email'); ?>
		<div class="clear"></div>
		<?= form_label('Название сайта:','userlabel'); ?>
		<?php $attr['name'] 		= 'sitename'; ?>
		<?php $attr['value'] 		= $sitename; ?>
		<?php echo form_input($attr); ?>
		<?= form_error('sitename'); ?>
		<div class="clear"></div>
		<?= form_label('Дата свадьбы:','userlabel'); ?>
		<?php $attr['name'] 		= 'weddingdate'; ?>
		<?php $attr['value'] 		= $weddingdate; ?>
		<?php $attr['id'] 			= 'wedding-date'; ?>
		<?php $attr['maxlength'] 	= '20'; ?>
		<?php $attr['size'] 		= '10'; ?>
		<?php $attr['readonly'] 	= TRUE; ?>
		<?php echo form_input($attr); ?>
		<?= form_error('weddingdate'); ?>
		<div class="clear"></div>
		<div class="clear"></div>
		<?php $attr['name'] 	= 'btnsubmit'; ?>
		<?php $attr['value'] 	= 'Сохранить'; ?>
		<?php $attr['class'] 	= 'senden'; ?>
		<?= form_submit($attr);?>
	</div>
<?= form_close(); ?>