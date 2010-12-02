<?php if($valid):
	$name 			= set_value('name');
	$profession 	= set_value('profession');
	$social1 		= set_value('social1');
	$hrefsocial1 	= set_value('hrefsocial1');
	$social2 		= set_value('social2');
	$hrefsocial2 	= set_value('hrefsocial2');
	$note 			= set_value('note');
else:
	$name 			= $friend['fr_name'];
	$profession 	= $friend['fr_profession'];
	$social1 		= $socials[0]['social'];
	$hrefsocial1 	= $socials[0]['href'];
	$social2 		= $socials[1]['social'];
	$hrefsocial2 	= $socials[1]['href'];
	$note 			= $friend['fr_note'];
endif; ?>
<?= form_open_multipart($formaction); ?>
	<div class="post-header-friend">
		<div class="post-title">
			<?php if($edit):?>
				<?= form_hidden('id',$friend['fr_id']); ?>
			<?php endif; ?>
			<?= form_label('Имя друга: &nbsp;&nbsp;','friendlabel'); ?>
			<?php $attr = array(
						'name' 		=> 'name',
            			'id'   		=> 'friendname',
            			'value'		=> $name,
						'class'		=> 'textfield',
            			'maxlength'	=> '40',
            			'size' 		=> '25'
				); 
			echo form_input($attr); ?>
			<div>
				<?= form_label('Профессия: ','friendlabel'); ?>
				<?php $attr = array(
							'name' 		=> 'profession',
              				'id'   		=> 'friendprof',
              				'value'		=> $profession,
							'class'		=> 'textfield',
              				'maxlength'	=> '50',
              				'size' 		=> '25'
						);
				echo form_input($attr); ?>
				<?= form_label('Фото: ','friendlabel'); ?>
				<?php $attr = array(
							'type'		=> 'file',
							'name'		=> 'userfile',
							'id'		=> 'uploadimage',
							'accept'	=> 'image/jpeg,png,gif',
							);
				echo form_input($attr); ?>
			</div>
		</div>
	</div>
	<div class="post-header-friend">
		<div class="post-title">
			<?= form_label('Соц.сеть:  ','friendlabel'); ?>
			<?php $attr = array(
						'name'		=> 'social1',
            			'id'   		=> 'friendsocial1',
            			'value'		=> $social1,
						'class'		=> 'textfield',
            			'maxlength'	=> '40',
            			'size' 		=> '25'
					);
			echo form_input($attr); ?>
			<?= form_label('Ссылка:  ','friendlabel'); ?>
			<?php $attr = array(
						'name' 		=> 'hrefsocial1',
            			'id'   		=> 'friendhrefsoc1',
            			'value'		=> $hrefsocial1,
						'class'		=> 'textfield',
            			'maxlength'	=> '50',
            			'size' 		=> '40'
				);
			echo form_input($attr); ?>
			<div>
				<?= form_label('Соц.сеть:  ','friendlabel'); ?>
				<?php $attr = array(
							'name' 		=> 'social2',
              				'id'   		=> 'friendsocial2',
              				'value'		=> $social2,
							'class'		=> 'textfield',
              				'maxlength'	=> '40',
              				'size' 		=> '25'
						);
				echo form_input($attr); ?>
				<?= form_label('Ссылка:  ','friendlabel'); ?>
				<?php $attr = array(
							'name' 		=> 'hrefsocial2',
              				'id'   		=> 'friendhrefsoc2',
              				'value'		=> $hrefsocial2,
							'class'		=> 'textfield',
              				'maxlength'	=> '50',
              				'size' 		=> '40'
						);
				echo form_input($attr); ?>
			</div>
		</div>
	</div>
	<div class="text">
		<div class="post-title">
			<?= form_label('Описание друга:  ','friendlabel');?>
		</div>
		<div>
			<?php $attr =array(
					'name' 		=> 'note',
        			'id'   		=> 'friendnote',
        			'value'		=> $note,
					'class'		=> 'textfield',
        			'cols'		=> '81',
        			'rows' 		=> '6',
				);	?>
			<?= form_textarea($attr); ?>
		</div>
		<?php $attr =array(
					'name' 	=> 'btnsubmit',
					'id'   	=> 'btnsubmit',
					'class' => 'senden',
					'value'	=> 'Сохранить'
				);
		echo form_submit($attr); ?>
	</div>
<?= form_close(); ?>