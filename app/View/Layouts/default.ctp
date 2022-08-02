<?php
$defaultDescription = __('meta.default_description');
$title = $this->fetch('title');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title ?? $defaultDescription; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('jquery-ui.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		?>
		<script type="text/javascript">
			window.app_config = {
				base_url: '<?php echo BASE_URL; ?>',
				loggedId: <?php echo $this->Session->read('userDetail.id') ?? 0; ?>,
			}
			window.app_messages = {
				cannot_connect_msg: '<?php echo __d('errors', 'error.unable_to_connect'); ?>'
			}
		</script>
</head>
<body>
	<div ng-app="app">
		<div id="header">
			<nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
				<div class="collapse navbar-collapse">
					<a class="navbar-brand"><?php echo $defaultDescription; ?></a>
				</div>
			<?php echo $this->element('UserNav'); ?>
		</div>
		<div id="content" class="container my-5">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<div class="text-center p-4 bg-light">
				<?php echo sprintf(__('label.copyright', date('Y'))); ?>
				<a class="text-reset fw-bold">message-board.net</a>
			</div>
		</div>
	</div>
	<?php
	echo $this->Html->script([
		'jquery.3.6.0.min',
		'jquery-ui.min',
		'bootstrap.min',
		'angular.1.8.2.min',
		'app'
	]);
	echo $this->fetch('script');
	?>
</body>
</html>
