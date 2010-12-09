<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
 	<title><?= $title; ?></title>
 	<meta name="description" content="<?= $description; ?>">
 	<meta name="keywords" content="<?= $keywords; ?>"/>
 	<meta name="author" content="<?= $author; ?>">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link rel="shortcut icon" href="<?= $baseurl.$themeurl; ?>/favicon.ico">
 	<link rel="apple-touch-icon" href="<?= $baseurl.$themeurl; ?>/apple-touch-icon.png">
	<link rel="stylesheet" href="<?= $baseurl; ?>css/960.css?v=1" type="text/css" />
	<link rel="stylesheet" href="<?= $baseurl.$themeurl; ?>/css/style.css?v=2" type="text/css" />
 	<script src="<?= $baseurl; ?>javascript/modernizr-1.6.min.js"></script>
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('administrator/header-admin'); ?>
		<div id="main">
			<div class="container_12">
				<?php $this->load->view('message');?>
				<div class="grid_6">
					<div id="summaries" class="grid_4 suffix_2">
						<span class="separated">
							<a href="<?= $baseurl.$usite.'/events'; ?>">Управление событиями &nbsp;&rarr;</a>
						</span>
					</div>
					<div class="clear"></div>
					<div id="summaries" class="grid_4 suffix_2">
						<span class="separated">
							<a href="<?= $baseurl.$usite.'/photo-albums'; ?>">Управление альбомами &nbsp;&rarr;</a>
						</span>
					</div>
					<div class="clear"></div>
					<div id="summaries" class="grid_4 suffix_2">
						<span class="separated">
							<a href="<?= $baseurl.$usite.'/friends'; ?>">Карточки друзей &nbsp;&rarr;</a>
						</span>
					</div>
					<div id="summaries" class="grid_4 suffix_2">
						<span class="separated">
							<a href="<?= $baseurl.$usite.'/admin/comments'; ?>">Cписок комментариев &nbsp;&rarr;</a>
						</span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="grid_6">
					<div id="summaries" class="grid_4 suffix_2">
						<span class="separated">	
							<a href="<?= $baseurl.$usite.'/admin/profile'; ?>">Изменение профиля &nbsp;&rarr;</a>
						</span>
					</div>
					<div class="clear"></div>
					<div id="summaries" class="grid_4 suffix_2">
						<span class="separated">
							<a href="<?= $baseurl.$usite.'/admin/password'; ?>">Изменение пароля &nbsp;&rarr;</a>
						</span>
					</div>
					<div class="clear"></div>
					<div id="summaries" class="grid_4 suffix_2">
						<span class="separated">	
							<a href="<?= $baseurl.$usite.'/admin/theme'; ?>">Изменение темы сайта &nbsp;&rarr;</a>
						</span>
					</div>
					<div class="clear"></div>
					<div id="summaries" class="grid_4 suffix_2">
						<span class="separated">
							<a href="<?= $baseurl.$usite; ?>">На главную страницу &nbsp;&rarr;</a>
						</span>
					</div>
				</div>
				<div class="clear"></div>
				<?= form_fieldset('Быстрый вызов функций',array('class'=>'fieldset')); ?>
					<div class="grid_12">
						<div id="summaries" class="grid_4">
							<span class="separated">
								<a href="<?= $baseurl.$usite.'/event-new'; ?>">Создать новое событие &nbsp;&rarr;</a>
							</span>
						</div>
						<div id="summaries" class="grid_4">
							<span class="separated">
								<a href="<?= $baseurl.$usite.'/album-new'; ?>">Создать новый альбом &nbsp;&rarr;</a>
							</span>
						</div>
						<div id="summaries" class="grid_3">
							<span class="separated">
								<a href="<?= $baseurl.$usite.'/friend-new'; ?>">Создать карточку друга &nbsp;&rarr;</a>
							</span>
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