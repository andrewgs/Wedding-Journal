<?php if($message['status']): ?>
	<div class="message">
		<?if(!empty($message['saccessfull'])): ?>
			<?=$message['saccessfull']; ?><br/>
		<?php endif; ?>
		<?if(!empty($message['message'])): ?>
			<?= $message['message']; ?><br/>
		<?php endif; ?>
		<?if(!empty($message['error'])): ?>
			<?= $message['error']; ?><br/>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
<?php endif; ?>