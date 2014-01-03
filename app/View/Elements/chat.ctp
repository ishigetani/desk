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
            <div id="body">Body:<?php echo $chat['Chat']['chat']; ?></div>
            <div id="Category">Category:<?php echo $chat['Category']['name']; ?></div>
            <div id="date"><?php echo $chat['Chat']['modified']; ?></div>
        </div>
    <?php endforeach; ?>
</div>