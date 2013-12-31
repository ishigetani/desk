<div class="chats view">
<h2><?php echo __('Chat'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($chat['Chat']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($chat['User']['name'], array('controller' => 'users', 'action' => 'view', $chat['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Chat'); ?></dt>
		<dd>
			<?php echo h($chat['Chat']['chat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($chat['Category']['name'], array('controller' => 'categories', 'action' => 'view', $chat['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($chat['Chat']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($chat['Chat']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>