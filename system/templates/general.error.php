<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Error <? echo $error_code ?>: <? echo $title ?></title>
		<style type="text/css">
			#error-container {
				margin: 5px;
				padding: 10px;
				border: 1px solid #ddd;
				font: 13px/20px Helvetica, Arial, sans-serif;
				color: #555;
			}

			#error-container h1 { color: #333; }
			#error-container span.code { color: #800; }
		</style>
	</head>
	<body>
		<div id="error-container" class="<? echo $tpl ?>">
			<h1><span class="code"><? echo $error_code ?>:</span> <? echo $title ?></h1>
			<? echo $msg ?>
		</div>
	</body>
</html>