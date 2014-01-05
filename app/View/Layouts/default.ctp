<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> | <?php echo DESK_TITLE; ?>
	</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('main');


		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>DESK</h1>
		</div>
        <div id="sidebar">
            <?php echo $this->element('sidebar'); ?>
        </div>
        <div id="content">
            <?php echo $this->Html->script('jquery.tgTwNotifyMessage1'); ?>

            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>
        </div>
		<div id="footer">
            Copyright &copy; 2013 - <?php echo $year_time; ?> Conyative
		</div>
	</div>
</body>
</html>
