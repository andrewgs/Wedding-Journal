<?php if($admin): ?>
	<div id="admin-panel">
	<span>Вы вошли как Администратор</span>
		  &nbsp;&nbsp;<a class="logout" href="<?= $baseurl.$usite ?>/admin">Управление</a>&nbsp;|
		  <a class="logout" href="<?= $baseurl.$usite ?>/logoff">Завершить сеанс</a>
	</div>
<?php endif; ?>
<header role="main"> 
	<div class="container_12">
		<div id="logo" class="grid_3 suffix_4">
			<?= anchor($baseurl.$usite,'<img src="'.$baseurl.$themeurl.'/images/logo.png" alt="v"/>'); ?>
		</div>
		<div class="grid_5">
			<ul id="header-menu">
				<li><?= anchor($usite.'/about','О нас');?></li>
				<li><?= anchor($usite.'/friends','Друзья');?></li>
				<li><?= anchor($usite.'/events','События');?></li>
				<li><?= anchor($usite.'/photo-albums','Фотографии');?></li>
			</ul>
		</div>	
	</div>
	<div class="clear"></div>
</header>