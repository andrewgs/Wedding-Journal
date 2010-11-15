<div class="grid_12">
	<?= form_error('imagetitle'); ?>
	<?= form_error('userfile'); ?>
	<div class="clear"></div>
	<div class="grid_3">
		<button id="singleupload">Добавить одну фотографию</button>
	</div>
	<div class="grid_3">
		<button id="multiupload">Добавить несколько фотографий</button>
	</div>
	<div class="clear"></div>
	<div id="ssuwindow"> 	
		<div id="ssuwindowswidget">
			<fieldset class="singleuploadform">
				<legend><strong>Загрузка одной фотографии</strong></legend>
				<?= form_open_multipart($formaction1);?>
					<?= form_label('Описание: ','uploadlabel'); ?>
					<?php $attr = array(
								'name'		=> 'imagetitle',
								'id'  		=> 'imagetitle',
								'class'		=> 'textfield',
								'value'		=> set_value('imagetitle'),
								'maxlength'	=> '100',
								'size' 		=> '30'
							);
					echo form_input($attr);?>
					<div>
						<?= form_label('Фото: ','albumlabel'); ?>
						<?php $attr = array(
									'type'		=> 'file',
									'name'		=> 'userfile',
									'id'		=> 'uploadimage',
									'accept'	=> 'image/jpeg,png,gif',
							);
						echo form_input($attr); ?>
					</div>
					<hr>
					<?php $attr =array(
								'name' 		=> 'btnsubmit',
								'id'   		=> 'btnsubmit',
								'class' 	=> 'senden',
								'value'		=> 'Загрузить'
							);
					echo form_submit($attr);?>
				<?= form_close(); ?>
				<button id="closesingleupload" class="senden">Отменить</button>
			</fieldset>
		</div> 
    </div>
	<div id="smuwindow"> 	
		<div id="smuwindowswidget">
			<fieldset class="multiupload">
				<legend><strong>Загрузка нескольких фотографий</strong></legend>
				<?= form_open_multipart($formaction2,array('id'=>'uploadForm'));?>
				<?= form_hidden('album',$album); ?>
				<img id="loading" src="<?= $baseurl; ?>images/loading.gif" style="display:none;float:left;"/>
				<?= form_upload(array('name'=>'fileToUpload[]','id'=>'fileToUpload','class'=>'MultiFile'));?>
				<hr>
				<?= form_submit(array('name'=>'btnsubmit','id'=>'btnsubmit','class'=>'senden','value'=>'Загрузить'));?>
				<?= form_close(); ?>
				<button id="closemultiupload" class="senden">Отменить</button>
				<div id="uploadOutput"></div>
			</fieldset>
		</div> 
    </div>
</div>