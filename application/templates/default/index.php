<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title><? echo $this->get_title(); ?></title>

		<? echo $this->get_meta(); ?>
		<? echo $this->get_css(); ?>
		<? echo $this->get_javascript(); ?>
	</head>
	<body>
		<? echo $content; ?>
	</body>
</html>