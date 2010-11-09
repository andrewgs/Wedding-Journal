<?= form_error('email'); ?>
<?= form_open($formaction); ?>
	<div class="b-auth-inputs">
		E-mail:
		<?php $attr = array(
				'name'		=> 'email',
				'class'		=> 'auth_input'
			); ?>
		<?php echo form_input($attr); ?>
	</div>
	<?php $attr =array(
				'name'		=> 'btsubmit',
				'id'		=> 'btsubmit',
				'value'		=> 'отправить',
			); ?>
	<?php echo form_submit($attr); ?>
<?php echo form_close(); ?>