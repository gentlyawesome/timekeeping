<!DOCTYPE html>
<html lang="en">
<head>
<title>Error</title>
<?
	$config = get_config();
	$base_url = $config['base_url'];
?>
<link href="<?php echo $base_url.'assets/css/bootstrap.min.css'; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $base_url.'assets/css/pace.css'; ?>" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="container" class='container'>
		<div class="row">
			<div class="col-md-12">
				<div class="well">
					<b><?php echo $heading; ?></b>
				</div>
				<div class="well">
					<?php echo $message; ?>
				</div>
				<div class="well">
					<button class='btn btn-info' onclick="window.history.back()">
						BACK TO PREVIOUS PAGE
					</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>