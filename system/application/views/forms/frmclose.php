<?= form_open($formaction); ?>
	<div id="edit-name-wrapper" class="form-item">
		<div>
		 	Вы решили удалить сайт! Сайт будет доступен еще 30 дней, на протяжении которых можно будет его восстановить.<br/>
			Зайтите в панель администрирования для активации отключенного сайта.
		 </div>
		 <? $attr = array(
				'name'		=> 'close',
				'id'		=> 'close',
				'value'		=> 'close',
				'checked'	=> FALSE,
			); ?>
		<?= form_checkbox($attr); ?>Подтверждение закрытия сайта
		<div>
			<?php $attr =array(
					'name' 		=> 'btnsubmit',
					'id'		=> 'btnsubmit',
					'class' 	=> 'senden',
					'disabled' 	=> TRUE,
					'value'		=> 'Закрыть сайт'
				); ?>
			<?= form_submit($attr);?>
		</div>
	</div>
<?= form_close(); ?>