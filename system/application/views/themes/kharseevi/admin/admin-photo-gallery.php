<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <meta http-equiv="Pragma" content="no-cache"/> 
    <meta http-equiv="Cache-Control" content="no-cache"/> 
    <meta http-equiv="Expires" content="1 Jan 2000 0:00:00 GMT"/> 
	<meta name="language" content="ru" /> 
    <meta name="description" content=<?php echo $pagevalue['desc']; ?>/>
    <meta name="keywords" content=<?php echo $pagevalue['keyword']; ?>/>
    <title><?php echo $pagevalue['title']; ?></title> 
<?php
	define("CRLT", "\n");
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/reset.css" type="text/css" />'.CRLT; 
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/960.css" type="text/css" />'.CRLT; 
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/style.css" type="text/css" />'.CRLT;
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/pirobox.css" type="text/css" />'.CRLT;
	
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.min.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/pirobox.min.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.confirm.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.MultiFile.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.form.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.blockUI.js"></script>'.CRLT;
?> 
	<script type="text/javascript" language="javascript">
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
					remove		:'<img src="<?php echo $pagevalue['baseurl']?>images/cancel.png" height="16" width="16" alt="cancel"/>',
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
		<?php $this->load->view('admin/header-admin',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?php echo $pagevalue['baseurl'].$pagevalue['backpath']; ?>">&nbsp;&larr;&nbsp; Вернуться назад</a>
				</div>
			</div>
			<div class="clear"></div>
			<div class="container_12">
				<div class="grid_12">
					<?php echo form_error('imagetitle').'<div class="clear"></div>'; ?>
					<?php echo form_error('userfile').'<div class="clear"></div>'; ?>
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
							<?php echo form_open_multipart('admin/photo-gallary/'.$pagevalue['album']);?>
							<?php echo form_hidden('album',$pagevalue['album']); ?>
								<?php echo '<div>'.form_label('Описание: ','uploadlabel'); ?>
								<?php $attr = array(
										'name'		=> 'imagetitle',
										'id'  		=> 'imagetitle',
										'class'		=> 'textfield',
										'value'		=> set_value('imagetitle'),
										'maxlength'	=> '100',
										'size' 		=> '30'
									);
									echo form_input($attr).'</div>';?>
								<?php echo '<div>'.form_label('Фото: ','albumlabel'); ?>
								<?php $attr = array(
										'type'		=> 'file',
										'name'		=> 'userfile',
										'id'		=> 'uploadimage',
										'accept'	=> 'image/jpeg,png,gif',
								);
								echo form_input($attr).'</div>'; ?>
								<hr>
								<?php $attr =array(
										'name' 		=> 'btnsubmit',
										'id'   		=> 'btnsubmit',
										'class' 	=> 'senden',
										'value'		=> 'Загрузить'
									);
								echo form_submit($attr);?>
							<?php echo form_close(); ?>
							<button id="closesingleupload" class="senden">Отменить</button>
							</fieldset>
						</div> 
    				</div>
					<div id="smuwindow"> 	
						<div id="smuwindowswidget">
							<fieldset class="multiupload">
								<legend><strong>Загрузка нескольких фотографий</strong></legend>
							<?php echo form_open_multipart('admin/photo-upload',array('id'=>'uploadForm'));?>
								<?php echo form_hidden('album',$pagevalue['album']); ?>
								<img id="loading" src="<?php echo $pagevalue['baseurl']?>images/loading.gif" style="display:none;float:left;"/>
								<?php echo form_upload(array('name'=>'fileToUpload[]','id'=>'fileToUpload','class'=>'MultiFile'));?>
							<hr>
								<?php echo form_submit(array('name'=>'btnsubmit','id'=>'btnsubmit','class'=>'senden','value'=>'Загрузить'));?>
							<?php echo form_close(); ?>
							<button id="closemultiupload" class="senden">Отменить</button>
							<div id="uploadOutput"></div>
							</fieldset>
						</div> 
    				</div>
				</div>
				<?php if($msg['status'] == 1){
						echo '<div class="message">';
							echo $msg['message'].'<br/>'.$msg['error'];
							echo $msg['saccessfull'];
						echo '</div>';
						echo '<div class="clear"></div>';
					} ?>
			<?php if(count($images)):?>
				<div id="photo-gallery" class="container_12">
				<?php for($i = 0;$i < count($images);$i++): ?>
					<div class="grid_3 photo-album">
						<div class="album-background images">
						<?php $link = $pagevalue['baseurl'].'big/viewimage/'.$images[$i]['img_id']; ?>
						<?php $text = '<img src="'.$pagevalue['baseurl'].'small/viewimage/'.$images[$i]['img_id'].'" 
									alt="'.$images[$i]['img_title'].'" '.'title="'.$images[$i]['img_title'].'"/></a>'; ?>
						<?php $attr = array('class'=>'pirobox','title'=>$images[$i]['img_title']); ?>
						<?php echo anchor($link,$text,$attr); ?>
						</div>
						<div class="images-text"> 
							<div class="image-title"><?php echo $images[$i]['img_title']; ?></div>
						</div>
						<div class="album-controls">
							<?php
								$text = 'Удалить';
								$str_uri = 'admin/photo-destory/'.$images[$i]['img_id'];
								$attr = array('class'=>'delete');
								echo anchor($str_uri,$text,$attr);
							?>
						</div>
						<div class="clear"></div>
					</div>
				<?php endfor; ?>
				</div>
				<div class="clear"></div>
			<?php endif; ?>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view('footer'); ?>