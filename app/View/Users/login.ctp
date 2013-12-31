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
<?php echo $this->Form->input('name', array('label' => false, 'class' => 'validate[required]')); ?>
    <P>Password</P>
<?php echo $this->Form->input('passwd', array('label' => false, 'class' => 'validate[required]')); ?>
<?php echo $this->Form->end('LOGIN', array('class' => 'submit')); ?>
</div>
