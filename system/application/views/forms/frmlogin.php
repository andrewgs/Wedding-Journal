<?= form_open($formaction); ?>
	<div class="b-auth-inputs">
		Логин:
		<?php $attr = array(
				'name' 		=> 'login',
				'class'		=> 'auth_input'
			); ?>
		<?= form_input($attr); ?>
		<span>Пароль:</span>
		<?php $attr = array(
				'name' 		=> 'password',
				'class'		=> 'auth_input'
			); ?>
		<?= form_password($attr); ?>
	</div>
	<?php $attr =array(
				'name' 		=> 'btsubmit',
				'id'   		=> 'btsubmit',
				'value'		=> 'Авторизоваться',
			); ?>
	<?= form_submit($attr); ?>
	<div class="b-auth-links">
		<span>
			<?= anchor('restore','Забыли пароль?'); ?>
		</span>
	</div>
<?= form_close(); ?>