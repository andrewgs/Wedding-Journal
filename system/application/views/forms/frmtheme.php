<?= form_open($formaction);?>
	<?php for($i = 0; $i < count($themes);$i++):?>
		<h3>Название темы: <?= $themes[$i]['thname']; ?></h3>
		<h4>Статус темы: <?= $themes[$i]['thstatus']; ?></h4>
		<h4>Цена темы: <?= $themes[$i]['thprice']; ?></h4>
		<?= form_radio(array('name'=>'theme','value'=>$themes[$i]['thid'])); ?>Выбрать тему "<?= $themes[$i]['thname']; ?>"
		<hr/>
	<?php endfor; ?>
	<div class="clear"></div>
	<?php $attr = array('name'=>'btsubmit','class'=>'','value'=>'Продолжить'); ?>
	<?= form_submit($attr); ?>
<?= form_close(); ?>