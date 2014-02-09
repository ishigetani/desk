<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 13/12/28
 * Time: 14:47
 */
?>
<?php echo $this->element('validate'); ?>
<div id="login-form">
<p class="form-title">LOGIN</p>
<?php echo $this->Session->flash("auth"); ?>
<?php echo $this->Form->create('User', array('id' => 'form-validate')); ?>
    <P>Name</P>
<?php echo $this->Form->input('name', array('label' => false, 'class' => 'validate[required,custom[onlyLetterNumber]]', 'required' => false)); ?>
    <P>Password</P>
<?php echo $this->Form->input('passwd', array('label' => false, 'class' => 'validate[required]', 'required' => false)); ?>
<?php echo $this->Form->end('LOGIN', array('class' => 'submit')); ?>
   <?php echo $this->Html->link('新しくグループを作成する', array('controller' => 'groups', 'action' => 'add')); ?>
</div>
