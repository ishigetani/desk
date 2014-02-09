<?php echo $this->element('validate'); ?>
<div class="groups form">
<?php echo $this->Form->create('Group', array('id' => 'form-validate')); ?>
	<fieldset>
		<legend>グループ情報</legend>
	<?php
		echo $this->Form->input('Group.name', array('class' => 'validate[required]', 'required' => false));
	?>
	</fieldset>
    <br />
    <fieldset>
        <legend>ユーザ情報</legend>
        <?php
        echo $this->Form->input('User.name', array('class' => 'validate[required,custom[onlyLetterNumber]]', 'required' => false));
        echo $this->Form->input('User.passwd', array('label' => 'Password', 'class' => 'validate[required]', 'required' => false));
        echo $this->Form->input('User.mail', array('class' => 'validate[required,custom[email]]', 'required' => false));
        ?>
    </fieldset>
    <p>※全て必須項目です</p>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
