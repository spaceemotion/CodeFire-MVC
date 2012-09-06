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
				padding: 25px;
			}

			h1 {
				padding-bottom: 10px;
				border-bottom: 1px dotted #ddd;
				margin: 5px 0 15px;
				color: #333;
			}

			em { color: #900; }

			small {
				clear: both;
				display: block;
				padding-top: 10px;
			}

			#wrapper {
				background: #fff;
				border: 1px solid #ddd;
				width: 960px;
				margin: 0 auto;
				padding: 15px;
				box-shadow: 0 0 3px #ddd;
			}

			.columns .left {
				float: left;
				width: 75%;
			}

			.columns .right {
				float: right;
				width: 23%;
				background: #f2f2f2;
				border: 1px solid #e9e9e9;
				padding: 5px;
			}
		</style>

		<? echo $this->get_javascript(); ?>
	</head>
	<body>
		<div id="wrapper"><? echo $content; ?></div>
	</body>
</html>