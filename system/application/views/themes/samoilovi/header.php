<?php if($admin): ?>
	<div id="admin-panel">
	<span>Вы вошли как Администратор</span>
		  &nbsp;&nbsp;<a class="logout" href="<?= $baseurl.$usite ?>/admin">Управление</a>&nbsp;|
		  <a class="logout" href="<?= $baseurl.$usite ?>/logoff">Завершить сеанс</a>
	</div>
<?php endif; ?>
<div id="header">
	<div class="container_16">
		<div id="logo" class="grid_4 suffix_5">
		<?php echo anchor($baseurl.$usite,'<img src="'.$baseurl.$themeurl.'/images/logo.png" alt=""/>'); ?>
		</div>
		<div class="grid_7">
			<ul id="header-menu">
			<?php echo "<li>".anchor($usite.'/about','О нас')."</li>"; ?>
			<?php echo "<li>".anchor($usite.'/friends','Друзья')."</li>"; ?>
			<?php echo "<li>".anchor($usite.'/events','События')."</li>"; ?>
			<?php echo "<li>".anchor($usite.'/photo-albums','Фотографии')."</li>"; ?>							
			</ul>
		</div>	
	</div>
	<div class="clear"></div>
</div>