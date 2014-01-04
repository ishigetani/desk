<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 14/01/03
 * Time: 14:06
 */
?>

<div id="chat-list">
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
</div>