<?php if($message['status']): ?>
	<div class="message">
		<?if($message['saccessfull'] != 'none'): ?>
			<?=$message['saccessfull']; ?><br/>
		<?php endif; ?>
		<?if($message['message'] != 'none'): ?>
			<?= $message['message']; ?><br/>
		<?php endif; ?>
		<?if($message['error'] != 'none'): ?>
			<?= $message['error']; ?><br/>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
<?php endif; ?>