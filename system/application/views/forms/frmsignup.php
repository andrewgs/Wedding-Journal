<div class="b-left-side">
	<div class="b-block-name">Регистрация</div>
	<div class="b-inside-left">
		<div class="h-inside-left">
			<div class="b-content-362-ins">
				<div class="h-block">
				<?php echo form_open($formaction); ?>
					<?php $attr = array('name'=>'','id'=>'','class'=>'join_input','value'=>'','maxlength'=>'60'); ?>
					<dl>
						<dt>Ваш логин:</dt>
						<dd>
						<?php $attr['name'] 	= 'login'; ?>
						<?php $attr['value'] 	= set_value('login'); ?>
						<?= form_input($attr); ?>
						</dd>
						<?= form_error('login'); ?>
						<dt>Ваш пароль:</dt>
						<dd>
						<?php $attr['name'] 	= 'password'; ?>
						<?php $attr['value'] 	= set_value('password'); ?>
						<?= form_password($attr); ?>
						</dd>
						<?= form_error('password'); ?>
						<dt>Подтверждение пароля:</dt>
						<dd>
						<?php $attr['name'] 	= 'confirmpass'; ?>
						<?php $attr['value'] 	= set_value('confirmpass'); ?>
						<?= form_password($attr); ?>
						</dd>
						<dt>Название сайта:</dt>
						<dd>
						<?php $attr['name'] 		= 'sitename'; ?>
						<?php $attr['value'] 		= set_value('sitename'); ?>
						<?= form_input($attr); ?>
						</dd>
						<?= form_error('sitename'); ?>
						<dt>Ваше имя:</dt>
						<dd>
						<?php $attr['name'] 		= 'name'; ?>
						<?php $attr['value'] 		= set_value('name'); ?>
						<?= form_input($attr); ?>
						</dd>
						<?= form_error('name'); ?>
						<dt>Ваша фамилия:</dt>
						<dd>
						<?php $attr['name'] 		= 'subname'; ?>
						<?php $attr['value'] 		= set_value('subname'); ?>
						<?= form_input($attr); ?>
						</dd>
						<?= form_error('subname'); ?>
						<dt>Ваш email:</dt>
						<dd>
						<?php $attr['name'] 		= 'email'; ?>
						<?php $attr['value'] 		= set_value('email'); ?>
						<?php $attr['maxlength'] 	= '255'; ?>
						<?= form_input($attr); ?>
						</dd>
						<?= form_error('email'); ?>
						<dt>Дата свадьбы:</dt>
						<dd>
						<?php $attr = array('name'=>'weddingdate','id'=>'wedding-date','class'=>'join_input',
											'value'=>set_value('weddingdate'),'maxlength'=>'20','readonly'=>TRUE); ?>
						<?= form_input($attr); ?>
						</dd>
						<?= form_error('weddingdate'); ?>
						<div class="clear"></div>
						<dt>Код защиты:</dt>
						<dd>
							<img src="<?= $baseurl; ?>capcha" alt=""/>
						<?php $attr = array('name'=>'code','class'=>'join_input','value'=>'','maxlength'=>'6'); ?>
						<?= form_input($attr); ?>
						</dd>
						<?= form_error('code'); ?>
					</dl>
					<div class="b-join-button">
					<?php $attr = array('name'=>'btsubmit','class'=>'','value'=>'Зарегистрироватся'); ?>
					<?= form_submit($attr); ?>
					</div>
				<?php echo form_close(); ?>
				</div>
			<div class="clr"></div>
		</div>
	</div>
	<div class="clr"></div> 
</div>
</div>