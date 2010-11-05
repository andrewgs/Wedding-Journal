<?php echo form_open($formaction); ?>
	<div class="b-auth-inputs">
		Логин:
		<?php $attr = array(
				'name' 		=> 'login',
				'class'		=> 'auth_input'
			); ?>
		<?php echo form_input($attr); ?>
		<span>Пароль:</span>
		<?php $attr = array(
				'name' 		=> 'password',
				'class'		=> 'auth_input'
			); ?>
		<?php echo form_password($attr); ?>
	</div>
	<?php $attr =array(
				'name' 		=> 'btsubmit',
				'id'   		=> 'btsubmit',
				'value'		=> 'Авторизоваться',
			); ?>
	<?php echo form_submit($attr); ?>
	<div class="b-auth-links">
		<span>
			<?php echo anchor('reminder_password','Забыли пароль?'); ?>
		</span>
	</div>
<?php echo form_close(); ?>