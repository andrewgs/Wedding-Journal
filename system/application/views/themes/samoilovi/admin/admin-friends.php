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
		
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.min.js"></script>'.CRLT;
	echo '<script type="text/javascript" src="'.$pagevalue['baseurl'].'js/jquery.confirm.js"></script>'.CRLT;
?> 
	<script type="text/javascript"> 
		$(document).ready(function(){
			$('a.delete').confirm();
		});
	</script> 	
</head>
<body>
	<div id="main-wrap">
		<?php $this->load->view('admin/header-admin',array('pagevalue'=>$pagevalue)); ?>
		<div id="content">
			<div class="container_12">
				<div id="internal_nav" class="grid_4">
					<a href="<?php echo $pagevalue['baseurl'].'admin/friend-new'; ?>">Создать карточку друга &nbsp;&rarr;</a>
				</div>
				<div class="clear"></div>
			<?php if($msg['status'] == 1):
					echo '<div class="message">';
					echo $msg['saccessfull'].'<br/>';
					echo $msg['message'].'<br/>'.$msg['error'];
					echo '</div>';
					echo '<div class="clear"></div>';
				endif; ?>
			</div>
			<?php $cnt = 0; ?>
			<?php for($i = 0;$i < $key/3;$i++): ?>	
			<div class="container_16 friend-vcards">
			<?php for($y = 0;$y < 3;$y++): ?>	
				<div class="grid_5 vcard">
					<div class="friend-info left">
					<?php echo '<img src="'.$pagevalue['baseurl'].'friend/viewimage/'.$friendcard[$i][$y]['id'].'"
									alt="'.$friendcard[$i][$y]['name'].'"/>'; ?>
					</div>
					<div class="friend-specs left">
						<div class="friend-name">
							<?php echo $friendcard[$i][$y]['name']; ?>
						</div>
						<div class="friend-profession">
							<?php echo $friendcard[$i][$y]['profession']; ?>
						</div>
					<?php if($friendcard[$i][$y]['social'] != 0):?>
							<div class="friend-social">
						<?php for($soc = 0;$soc < count($social); $soc++):
								if ($social[$soc]['soc_fr_id'] == $friendcard[$i][$y]['id'])	
									echo anchor($social[$soc]['soc_href'],$social[$soc]['soc_name'],array('target'=>'_blank')).' ';
							endfor; ?>
							</div>
					<?php endif; ?>						
						<hr/>
					</div>
					<div class="clear"></div>
					<div class="friend-note">
					<?php echo $friendcard[$i][$y]['note'];?>
					</div>
					<div class="friend-controls">
					<?php $text = 'Редактировать'; ?>
					<?php $str_uri = 'admin/friend-edit/'.$friendcard[$i][$y]['id'];?>
					<?php echo anchor($str_uri,$text); ?>
					<?php $text = ' Удалить'; ?>
					<?php $str_uri = '/admin/friend-destroy/'.$friendcard[$i][$y]['id']; ?>
					<?php $attr = array('class'=>'delete'); ?>
					<?php echo anchor($str_uri,$text,$attr); ?>
					</div>
				</div>
				<?php $cnt += 1; ?>
				<?php if ($cnt == $key) break; ?>
			<?php endfor; ?>
			</div>
			<div class="clear"></div>
		<?php endfor;?>						
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('footer'); ?>