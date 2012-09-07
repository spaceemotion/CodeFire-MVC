<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * config.php
	 *
	 * This file holds the site configuration and basic settings
	 * needed in order for the system to work properly.
	 *
	 * @package	system
	 * @version	1.0
	 */

	global $config, $db;


	/* Site Configuration */
		$config["site"]["production"] = false;
		$config["site"]["time_zone"] = "UTC";
		$config["site"]["title"] = "CodeFire";
		$config["site"]["userclass_prefix"] = "";

		$config["site"]["default_template"] = "default";

		// If true an error page will be displayed when no output was sent
		$config["site"]["nocontent404"] = true;


	/* Cache configuration */
		$config["cache"]["enabled"] = true;
		$config["cache"]["directory"] = TEMP_CACHE;

		// Cache time in minutes
		$config["cache"]["time"] = 0.1;

		// Cache levels:
		// 1: Save only generated data (template will be rerendered),
		// 2: Cache complete site output to file
		$config["cache"]["level"] = 1;


	/* Routing */
		$config["route"]["default_page"] = "demo";
		$config["route"]["404_overwrite"] = "";


	/* Autoloading of classes and files */
		$config["autoload"]["model"]	= array();
		$config["autoload"]["helper"]	= array();


	/* Default database connection details */
		$db["default"]["type"] = "mysql";
		$db["default"]["host"] = "localhost";
		$db["default"]["port"] = 3306;
		$db["default"]["user"] = "root";
		$db["default"]["passwd"] = "";
		$db["default"]["name"] = "";


?>
