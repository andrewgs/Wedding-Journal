<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<meta http-equiv="Pragma" content="no-cache"/>
	<meta http-equiv="Cache-Control" content="no-cache"/>
	<meta http-equiv="Expires" content="1 Jan 2000 0:00:00 GMT"/>
	<meta name="language" content="ru" />
	<meta name="description" content="<?= $description; ?>"/>
	<meta name="keywords" content="<?= $keywords; ?>"/>
	<title><?= $title; ?></title>
	<link rel="stylesheet" href="<?= $baseurl; ?>css/960.css" type="text/css" />
	<link rel="stylesheet" href="<?= $baseurl.$themeurl; ?>/css/reset.css" type="text/css" /> 
	<link rel="stylesheet" href="<?= $baseurl.$themeurl; ?>/css/style.css" type="text/css" />
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/admin/header-admin'); ?>
		<div id="content">
			<div class="container_12">
				<div class="grid_6">
					<div id="internal_nav" class="grid_4 suffix_2">
						<a href="<?= $baseurl.$usite.'/admin/events'; ?>">Управление событиями &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_2">
						<a href="<?= $baseurl.$usite.'/admin/comments'; ?>">Cписок комментариев &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_2">
						<a href="<?= $baseurl.$usite.'/admin/album-gallary'; ?>">Управление альбомами &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_2">
						<a href="<?= $baseurl.$usite.'/admin/friends'; ?>">Карточки друзей &nbsp;&rarr;</a>
					</div>
				</div>
				<div class="grid_6">
					<div id="internal_nav" class="grid_4 suffix_2">
						<a href="<?= $baseurl.$usite.'/admin/profile'; ?>">Изменение профиля &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_2">
						<a href="<?= $baseurl.$usite.'/admin/password'; ?>">Изменение пароля &nbsp;&rarr;</a>
					</div>
					<div class="clear"></div>
					<div id="internal_nav" class="grid_4 suffix_2">
						<a href="<?= $baseurl.$usite; ?>">На главную страницу &nbsp;&rarr;</a>
					</div>
				</div>
				<div class="clear"></div>
				<?php if($message['status']): ?>
					<div class="message">
						<?= $msg['saccessfull']; ?><br/>
						<?= $msg['message']; ?>	<br/>
						<?= $msg['error'];?>
					</div>
					<div class="clear"></div>
				<?php endif; ?>
				<?= form_fieldset('Быстрый вызов функций',array('class'=>'fieldset')); ?>
					<div class="grid_12">
						<div id="internal_nav" class="grid_4">
							<a href="<?= $baseurl.$usite.'/admin/event-new'; ?>">Создать новое событие &nbsp;&rarr;</a>
						</div>
						<div id="internal_nav" class="grid_4">
							<a href="<?= $baseurl.$usite.'/admin/album-new'; ?>">Создать новый альбом &nbsp;&rarr;</a>
						</div>
						<div id="internal_nav" class="grid_3">
							<a href="<?= $baseurl.$usite.'/admin/friend-new'; ?>">Создать карточку друга &nbsp;&rarr;</a>
						</div>
					</div>
					<div class="clear"></div>
				<?php echo form_fieldset_close(); ?>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>