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
        var flg = true;
        $(window).bottom({proximity: 0.05});
        $(window).on('bottom', function() {
            if (!flg) return;
            flg=false;
            <?php echo $this->Js->request(array('action' => 'contents_update', 'page:'. $nextPage),
                array(
                    'method' => 'get',
                    'sync' => true,
                    'update' => '#next-content',
                    'complete' => '$("#next-content:first").attr("id", "test");$("#next-script:first").remove();'
                ));?>
        });
    });
</script>
<?php foreach($chats as $chat): ?>
    <div id="chat-content">
        <div id="id">ID:<?php echo $chat['Chat']['id']; ?></div>
        <div id="name">Name:<?php echo $chat['User']['name']; ?></div>
        <div id="body">Body:<?php echo nl2br($chat['Chat']['chat']); ?></div>
        <div id="Category">Category:<?php echo $chat['Category']['name']; ?></div>
        <div id="date"><?php echo $chat['Chat']['modified']; ?></div>
        <div class="actions">
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $chat['Chat']['id'])); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $chat['Chat']['id']), null, __('Are you sure you want to delete # %s?', $chat['Chat']['id'])); ?>
        </div>
    </div>
<?php endforeach; ?>
<div id="next-content"></div>