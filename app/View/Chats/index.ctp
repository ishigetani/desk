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
            'update' => '#chat-contents'
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

<div id="button" class="button-update">リスト更新</div>
<div id="update-status"><?php echo $this->Html->image('ajax-loader.gif'); ?></div>
<div id="update-data">更新することが出来ます</div>
<script>
    <?php echo $this->Js->get('.button-update')->event(
        'click',
        $this->Js->request(
            array('action' => 'contents_update'),
            array(
                'before' => "$('#update-status').show();",
                'complete' => "$('#update-status').hide();$('#update-data').hide();",
                'method' => 'get',
                'sync' => true,
                'update' => '#chat-contents',
            )
        ),
        array('buffer' => false)
    ); ?>
</script>

<div class="chat-index">
    <?php echo $this->Form->input('category', array('type' => 'select','options' => $categories, 'id' => 'category-list', 'label' => 'Category:', 'empty' => true)); ?>
    <script>
        $(function() {
            $('select#category-list').change(function() {
                categoryId = $(this).val();
                $.ajax({dataType:"html", success:function (data, textStatus) {$("#chat-contents").html(data);},
                    sync:true, type:"get", url:"\/desk\/chats\/contents_update\/category:"+categoryId});
                $("#ChatCategoryId").val(categoryId);
            });
        });
    </script>
    <div id="chat-list">
        <script>
            $(function(){
                setInterval(function(){
                    <?php echo $this->Js->request(
                        array(
                            'action' => 'update_check',
                        ),
                        array(
                            'method' => 'get',
                            'async' => true,
                            'update' => '#chat-updating',
                        )
                    );
                    ?>
                }, <?php echo UPDATE_TIME; ?>);
            });
        </script>
        <div id="chat-updating">
            <?php echo $this->Element('chat_update'); ?>
        </div>
        <div id="chat-contents">
            <?php echo $this->Element('chat_contents'); ?>
        </div>
    </div>
</div>
<div class="chat-update"></div>