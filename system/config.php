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

	global $config;


	/* Site Configuration */
		$config["site"]["production"] = false;
		$config["site"]["time_zone"] = "UTC";
		$config["site"]["title"] = "";
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
		// 1: Save only sent data (template will be rerendered),
		// 2: Complete site (complete output to the browser)
		$config["cache"]["level"] = 1;


	/* Routing */
		$config["route"]["default_page"] = "demo/index";
		$config["route"]["404_overwrite"] = "";


	/* Autoloading of classes and files */
		$config["autoload"]["model"]	= array();
		$config["autoload"]["helper"]	= array();
		$config["autoload"]["plugins"]	= array();


	/* Default database connection details */
		$config["db"]["host"] = "";
		$config["db"]["user"] = "";
		$config["db"]["password"] = "";
		$config["db"]["name"] = "";


?>
