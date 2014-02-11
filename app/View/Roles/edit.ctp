<h3>権限編集</h3>
<div class="roles form">
<?php echo $this->Form->create('Role'); ?>
	<fieldset>
		<legend>基本情報</legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
