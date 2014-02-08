<div class="chats form">
<?php echo $this->Form->create('Chat'); ?>
	<fieldset>
		<legend><?php echo __('Edit Chat'); ?></legend>
        <?php echo $this->Form->error('user_id'); ?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('chat');
		echo $this->Form->input('category_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>