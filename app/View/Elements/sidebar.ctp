<?php
/**
 * Created by PhpStorm.
 * User: ishigetani
 * Date: 13/12/27
 * Time: 14:56
 */
?>
<?php echo $this->Html->script('jquery-contained-sticky-scroll-min'); ?>
<?php echo $this->Html->script('sidebar'); ?>
<?php echo $this->Html->css('sidebar'); ?>
<ul>
    <li>
        <h3 id="sidebar-header"><?php echo $userinfo['name']; ?>さん</h3>
        <ul id="sidebar-content">
            <li><?php echo $this->Html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout')); ?></li>
        </ul>
    </li>
    <li>
        <h3 id="sidebar-header">Chat</h3>
        <ul id="sidebar-content">
            <li><?php echo $this->Html->link(__('LIST'), array('controller' => 'chats', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('ADD'), array('controller' => 'chats', 'action' => 'add')); ?> </li>
        </ul>
    </li>

    <li>
        <h3 id="sidebar-header">Category</h3>
        <ul id="sidebar-content">
            <li><?php echo $this->Html->link(__('LIST'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('ADD'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
        </ul>
    </li>

    <li>
        <h3 id="sidebar-header">User</h3>
        <ul id="sidebar-content">
            <li><?php echo $this->Html->link(__('LIST'), array('controller' => 'users', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('ADD'), array('controller' => 'users', 'action' => 'add')); ?> </li>
        </ul>
    </li>

    <li>
        <h3 id="sidebar-header">Group</h3>
        <ul id="sidebar-content">
            <li><?php echo $this->Html->link(__('LIST'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('ADD'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
        </ul>
    </li>
</ul>