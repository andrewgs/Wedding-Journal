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
	<link rel="stylesheet" href="<?= $baseurl; ?>css/datepicker/jquery.ui.all.css" type="text/css" />
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery-1.4.2.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.bgiframe-2.1.1.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.datepicker-ru.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/datepicker/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>ckfinder/ckfinder.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
				var config = {
					skin : 'v2',
					removePlugins : 'scayt',
					resize_enabled: false,
					height: '200px',
					toolbar:
					[
						['Source','-','Preview','-','Templates'],
						['Cut','Copy','Paste','PasteText'],
						['Undo','Redo','-','SelectAll','RemoveFormat'],
						'/',
						['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
						['NumberedList','BulletedList','-','Outdent','Indent'],
						['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
						['Link','Unlink'],
						'/',
						['Format','-'],
						['Image','Table','HorizontalRule','SpecialChar','-'],
						['Maximize', 'ShowBlocks']
					]
				};
	
				$('#eventtext').ckeditor(config);
				var editor = $('#eventtext').ckeditorGet();
	
				CKFinder.setupCKEditor(editor,"<?= $baseurl.'ckfinder/'; ?>") ;
				$("input#event-date").datepicker($.datepicker.regional['ru']);
				$("div.blog-content").each(function(){
					$(this).parents("div.blog-center:first").css('height', $(this).height()+150);
				});
		});
	</script>
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/header'); ?>
		<div id="content">
			<?php $this->load->view('transitions/fullback'); ?>
			<div class="container_16">
				<?= form_error('title'); ?>
				<?= form_error('text'); ?>
				<?= form_error('date'); ?>
				<div id="blog" class="grid_16">
					<div class="blog-top"> 
						<div class="blog-tl"> </div>
						<div class="blog-t"> </div>
						<div class="blog-tr"> </div>
						<div class="clear"></div>
					</div>
					<div class="blog-center"> 
						<div class="blog-l"> </div>
						<div class="blog-content">
							<?php $this->load->view('forms/frmeventedit'); ?>
						</div>
						<div class="blog-r"> </div>
						<div class="clear"></div>
					</div>
					<div class="blog-bottom">
						<div class="blog-bl"></div>
						<div class="blog-b"></div>
						<div class="blog-br"></div>						
					 </div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>