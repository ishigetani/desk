<?php
$request = $this->Js->request(
    array(
        'action' => 'contents_update',
        ),
        array(
            'method' => 'get',
            'sync' => true,
            'update' => '#chat-contents',
        )
    );
?>
<div class="chat-reply"></div>
<div class="chat-add">
    <?php echo $this->Form->create('Chat'); ?>
    <?php echo $this->Form->input('chat', array('type' => 'textarea', 'maxlength' => 1000, 'label' => 'Message', 'id' => "chat-message")); ?>
    <div class="ChatAdd-right">
        <?php echo $this->Form->input('category_id', array('type' => 'select', 'options' => $categories, 'label' => 'Category')); ?>
        <?php echo $this->Js->submit('送信',
            array('id' => 'chat-add', 'url' => array('action' => 'add'), 'buffer' => false,
                'success'=>$request,
                'update'=>'.chat-reply',
            ));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<div class="chat-index">
    <h2><?php echo __('Chats'); ?></h2>
    <div id="chat-list">
        <?php echo $this->Element('chat'); ?>
    </div>
</div>
<div class="chat-update"></div>