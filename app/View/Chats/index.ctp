<?php
$request = $this->Js->request(
    array(
        'action' => 'index',
        ),
        array(
            'method' => 'get',
            'sync' => true,
            'update' => '#chat-list',
        )
    );
?>
<div class="chat-message"></div>
<div class="chat-add">
    <?php echo $this->Form->create('Chat'); ?>
    <?php echo $this->Form->input('chat', array('type' => 'textarea', 'maxlength' => 1000, 'label' => 'Message')); ?>
    <?php echo $this->Form->input('category_id', array('type' => 'select', 'options' => $categories, 'label' => 'Category')); ?>
    <?php echo $this->Js->submit('送信',
        array('id' => 'chat-add', 'url' => array('action' => 'add'), 'buffer' => false,
            'before'=>$this->Js->get('.chat-message')->effect('fadeIn'),
            'success'=>$request,
            'update'=>'.chat-message',
        ));
    ?>
    <?php echo $this->Form->end(); ?>
</div>
<div class="chat-index">
    <h2><?php echo __('Chats'); ?></h2>
    <?php echo $this->Element('chat'); ?>
</div>