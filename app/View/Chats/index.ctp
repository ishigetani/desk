<h2><?php echo __('Chats'); ?></h2>
<?php echo $this->Html->script('jquery.bottom-1.0'); ?>
<?php echo $this->Html->script('jquery.leanModal.min'); ?>
<?php echo $this->Html->script('pop-up'); ?>
<a rel="leanModal" href="#add-message" id="button">AddMessage</a>
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
<div class="chat-add" id ="add-message">
    <?php echo $this->Form->create('Chat'); ?>
    <?php echo $this->Form->input('chat', array('type' => 'textarea', 'maxlength' => 1000, 'label' => 'Message', 'id' => "chat-message")); ?>
    <div class="ChatAdd-right">
        <?php echo $this->Form->input('category_id', array('type' => 'select', 'options' => $categories, 'label' => 'Category')); ?>
        <?php echo $this->Js->submit('送信',
            array('id' => 'chat-add',
                'url' => array('action' => 'add'),
                'buffer' => false,
                'success'=>$request,
                'update'=>'.chat-reply',
            ));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<div class="chat-index">
    <div id="chat-list">
        <div id="chat-updating">
            <?php //echo $this->Element('chat_update'); ?>
        </div>
        <div id="chat-contents">
            <?php echo $this->Element('chat_contents'); ?>
        </div>
    </div>
</div>
<div class="chat-update"></div>