<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title><? echo $this->get_title(); ?></title>

		<? echo $this->get_meta(); ?>
		<? echo $this->get_css(); ?>
		<style type="text/css">
			* { margin: 0; padding: 0; }

			body {
				background: #f2f2f2;
				font: 13px/20px Helvetica, Arial, sans-serif;
				color: #555;
			}

			#wrapper {
				background: #fff;
				border: 1px solid #dfdfdf;
				width: 960px;
				margin: 25px auto;
				padding: 15px;
			}

			h1 {
				padding-bottom: 10px;
				border-bottom: 1px solid #eee;
				margin: 5px 0 15px;
				color: #333;
			}

			em { color: #900; }

			small {
				display: block;
				margin-top: 10px;
			}
		</style>

		<? echo $this->get_javascript(); ?>
	</head>
	<body>
		<div id="wrapper"><? echo $content; ?></div>
	</body>
</html>