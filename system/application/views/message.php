<?php if($message['status']): ?>
	<div class="message">
		<?= $message['saccessfull']; ?><br/>
		<?= $message['message']; ?>	<br/>
		<?= $message['error'];?>
	</div>
	<div class="clear"></div>
<?php endif; ?>