<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/05
 * Time: 14:14
 */
?>
<script id="next-script">
    $(function() {
        $(window).bottom({proximity: 0.05});
        $(window).one('bottom', function() {
            <?php echo $this->Js->request(array('action' => 'contents_update', 'page:'. $nextPage),
                array(
                    'method' => 'get',
                    'sync' => true,
                    'update' => '#next-content',
                    'complete' => '$("#next-content:first").attr("id", "updated-content");'
                ));?>
        });
    });
</script>
<?php foreach($chats as $chat): ?>
    <div id="chat-content" style="border-left-color: #<?php echo $chat['Category']['color']; ?>">
        <div id="name_id"><?php echo $chat['User']['name']; ?>:<?php echo $chat['Chat']['id']; ?></div>
        <div class="actions">
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $chat['Chat']['id'])); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $chat['Chat']['id']), null, __('Are you sure you want to delete # %s?', $chat['Chat']['id'])); ?>
        </div>
        <div id="body"><?php echo nl2br($chat['Chat']['chat']); ?></div>
        <div id="category">Category:<?php echo $chat['Category']['name']; ?></div>
        <div id="modified"><?php echo $chat['Chat']['modified']; ?></div>
    </div>
<?php endforeach; ?>
<div id="next-content"></div>