<?php echo $this->Html->script('jscolor/jscolor'); ?>
<div class="categories form">
<?php echo $this->Form->create('Category'); ?>
	<fieldset>
		<legend><?php echo __('Add Category'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('color', array('class' => 'color'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>