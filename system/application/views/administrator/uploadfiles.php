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
	<link rel="stylesheet" href="<?= $baseurl; ?>css/pirobox.css" type="text/css" />
	<script type="text/javascript" src="<?= $baseurl.$themeurl; ?>/javascript/jquery.min.js"></script>	
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/pirobox.min.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.confirm.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.MultiFile.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.form.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.blockUI.js"></script>
	<script type="text/javascript" src="<?= $baseurl.$themeurl; ?>/javascript/cfgmupload.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			﻿$('.MultiFile').MultiFile({ 
					accept:'jpg|jpeg|gif|png',max:5,STRING:{ 
					remove		:'<img src="<?= $baseurl; ?>images/cancel.png" height="16" width="16" alt="cancel"/>',
					file		:'$file', 
					selected	:'Выбраны: $file', 
					denied		:'Неверный тип файла: $ext!', 
					duplicate	:'Этот файл уже выбран:\n$file!' 
				},
				afterFileAppend: function(element, value, master_element){
					var fshgt = $('fieldset.multiupload').height();
					$('fieldset.multiupload').css({'height':fshgt+20});
					var topvalue = $('#closemultiupload').css("top").substring(0,$('#closemultiupload').css("top").indexOf("px"));
					$('#closemultiupload').css({'top':Number(topvalue)+20});
				},
				afterFileRemove: function(element, value, master_element){
					var fshgt = $('fieldset.multiupload').height();
					$('fieldset.multiupload').css({'height':fshgt-20});
					var topvalue = $('#closemultiupload').css("top").substring(0,$('#closemultiupload').css("top").indexOf("px"));
					$('#closemultiupload').css({'top':Number(topvalue)-20});
				}
			});		  
			$("#loading").ajaxStart(function(){$(this).show();}).ajaxComplete(function(){$(this).hide();});
			$('#uploadForm').ajaxForm({
					beforeSubmit: function(a,f,o){
					o.dataType = "html";
					$('#uploadOutput').html('Загрузка...');
					var fshgt = $('fieldset.multiupload').height();
					$('fieldset.multiupload').css({'height':fshgt+20});
				},
					success: function(data){
					$('#uploadOutput').empty();
					var fshgt = $('fieldset.multiupload').height();
					$('fieldset.multiupload').css({'height':fshgt-20});
				}
			});
		});
	</script>
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/admin/header-admin'); ?>
		<div id="content">
			<?php $this->load->view('transitions/fullback');?>
			<div class="container_12">
				<?php if($admin):?>
					<?php $this->load->view('message');?>
					<?php $this->load->view('forms/frmupload'); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>