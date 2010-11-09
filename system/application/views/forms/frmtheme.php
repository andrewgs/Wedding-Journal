<?php echo form_open($formaction);?>
	{themes}
		<h3>Название темы: {thname}</h3>
		<h4>Статус темы: {thstatus}</h4>
		<h4>Цена темы: {thprice}</h4>
	<?php echo form_radio(array('name'=>'theme','value'=>'{thid}')); ?>Выбрать тему "{thname}"
	<hr/>
	{/themes}
	<div class="clear"></div>
	<?php $attr = array('name'=>'btsubmit','class'=>'','value'=>'Продолжить'); ?>
	<?php echo form_submit($attr); ?>
<?php echo form_close(); ?>