
<?
	$config = get_config();
	$base_url = $config['base_url'];
?>
<link href="<?php echo $base_url.'assets/css/bootstrap.min.css'; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $base_url.'assets/css/pace.css'; ?>" rel="stylesheet" type="text/css" />

<div id="container" class='container'>
	<div class="row">
		<div class="col-md-12">
			<div class="well">
				A PHP Error was encountered
			</div>
			<div class="well">
				<p>Severity: <?php echo $severity; ?></p>
				<p>Message:  <?php echo $message; ?></p>
				<p>Filename: <?php echo $filepath; ?></p>
				<p>Line Number: <?php echo $line; ?></p>
			</div>
		</div>
	</div>
</div>
