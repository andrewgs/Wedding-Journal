<?= form_open($formaction); ?>
	<div id="edit-name-wrapper" class="form-item">
		<?= form_label('Ваше имя: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-name');
		$attr = array(
				'name' 		=> 'user_name',
				'id'   		=> 'username',
				'value'		=> set_value('user_name'),
				'maxlength'	=> '60',
				'size' 		=> '30',
				'class' 	=> 'form-text required'
			);
			if ($admin)
				$attr['value'] = $user['firstname'].' '.$user['secondname']; ?>
		<?= form_input($attr); ?>
	</div>
	<div id="edit-mail-wrapper" class="form-item">
		<?= form_label('E-mail: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-mail');
		$attr = array(
				'name' 		=> 'user_email',
				'id'   		=> 'useremail',
				'value'		=> set_value('user_email'),
				'maxlength'	=> '255',
				'size' 		=> '30',
				'class' 	=> 'form-text required'
			);
		if ($admin)
			$attr['value'] = $user['email']; ?>
			<?= form_input($attr);	?>
			<div class="description">Содержимое данного поля сохранится в нашей базе данных и не будет выводиться на экран.</div>
	</div>
	<div id="edit-homepage-wrapper" class="form-item">
		<?= form_label('Веб-сайт:','edit-homepage');
		$attr = array(
				'name' 		=> 'homepage',
				'id'   		=> 'edit-homepage',
				'value'		=> set_value('homepage'),
				'maxlength'	=> '255',
				'size' 		=> '30',
				'class' 	=> 'form-text'
			);
		if ($admin)
			$attr['value'] = 'http://realitygroup.ru/'; ?>
		<?= form_input($attr);?>
	</div>
	<div id="edit-comment-wrapper" class="form-item">
		<?= form_label('Комментарий: <span title="Это поле обязательно для заполнения." class="form-required">*</span>','edit-comment');?>
		<div class="resizable-textarea">
			<span>
				<?php $attr =array(
					'name'	=> 'cmnt_text',
					'id'  	=> 'cmnttext',
					'value'	=> set_value('cmnt_text'),
					'cols'	=> '60',
					'rows' 	=> '15',
					'class' => 'form-textarea resizable required textarea-processed'
				);
				echo form_textarea($attr); ?>										
			</span>
		</div>
	</div>
	<?php $attr =array(
				'name' 	=> 'commit',
				'id'   	=> 'ajax-comments-submit',
				'value'	=> 'Добавить комментарий',
				'class' => 'senden'
			);
	echo form_submit($attr); ?>
<?= form_close(); ?>