<div class="chats form">
<?php echo $this->Form->create('Chat'); ?>
	<fieldset>
		<legend><?php echo __('Add Chat'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('chat');
		echo $this->Form->input('category_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>