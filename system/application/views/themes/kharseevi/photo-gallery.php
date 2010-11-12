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
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery-1.3.1.min.js"></script>	
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/pirobox.min.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.confirm.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.MultiFile.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.form.js"></script>
	<script type="text/javascript" src="<?= $baseurl; ?>javascript/jquery.blockUI.js"></script>
		
	<script type="text/javascript"> 
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17193616-1']);
		_gaq.push(['_trackPageview']);
		(function(){
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		$(document).ready(function(){
			$().piroBox({
				my_speed: 400,
				bg_alpha: 0.1,
				slideShow : true,
				slideSpeed : 4,
				close_all : '.piro_close,.piro_overlay' 
			});
			$('a.delete').confirm();
			$('.MultiFile').MultiFile({ 
				accept:'jpg|gif|png|',max:5,STRING:{ 
					remove		:'<img src="<?=$baseurl;?>images/cancel.png" height="16" width="16" alt="cancel"/>',
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
			$(function(){
				$("#singleupload").click(function(){
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();
					$("fieldset.singleuploadform").slideDown("slow");
					$("#showuploadif").hide(1000);
					$('#ssuwindow').css({'width':maskWidth,'height':maskHeight});
					$('#ssuwindow').fadeIn(2000);
				});
				$("#closesingleupload").click(function(){
						$('#ssuwindow').fadeOut("slow",function(){$('#ssuwindow').hide();});
						$("fieldset.singleuploadform").hide(1000);
						$("#showuploadif").show(2000);
				});
				$("#multiupload").click(function(){
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();
					$("fieldset.multiupload").slideDown("slow");
					$("#showuploadif").hide(1000);
					$('#smuwindow').css({'width':maskWidth,'height':maskHeight});
					$('#smuwindow').fadeIn(2000);
				});
				$("#closemultiupload").click(function(){
						$('#smuwindow').fadeOut("slow",function(){$('#smuwindow').hide();});
						$("fieldset.multiupload").hide(1000);
						$("#showuploadif").show(2000);
				}); 
			});
		});
	</script>  	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view($themeurl.'/header'); ?>
		<div id="content">
			<?php $this->load->view('transitions/fullback');?>
			<div class="container_12">
				<?php if($admin):?>
					<?php $this->load->view('forms/frmupload'); ?>
					<?php $this->load->view('message');?>
				<?php endif; ?>
				<?php if(count($images)):?>
					<div id="photo-gallery" class="container_12">
					<?php for($i = 0;$i < count($images);$i++): ?>
						<div class="grid_3 photo-album">
							<div class="album-background images">
							<?php $link = $baseurl.'users/'.$usite.'/images/'.$images[$i]['img_src']; ?>
							<?php $text = '<img src="'.$baseurl.$usite.'/photo/viewimage/'.$images[$i]['img_id'].'" 
										alt="'.$images[$i]['img_title'].'" '.'title="'.$images[$i]['img_title'].'"/>'; ?>
							<?php $attr = array('class'=>'pirobox'); ?>
							<?= anchor($link,$text,$attr); ?>
							</div>
							<div class="images-text"> 
								<div class="image-title"><?= $images[$i]['img_title']; ?></div>
							</div>
						</div>
					<?php endfor; ?>
					</div>
					<div class="clear"></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view($themeurl.'/footer'); ?>
</body>
</html>