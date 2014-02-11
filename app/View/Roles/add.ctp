<div class="roles form">
<?php echo $this->Form->create('Role'); ?>
	<fieldset>
		<legend>権限追加</legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>