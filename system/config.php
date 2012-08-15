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
		$config["site"]["url"] = "";
		$config["site"]["userclass_prefix"] = "";


	/* Routing */
		$config["route"]["default_method"] = "index";
		$config["route"]["default_controller"] = "demo";

		$config["route"]["404_overwrite"] = "";


	/* Autoloading of classes and files */
		$config["autoload"]["model"]	= array();
		$config["autoload"]["helper"]	= array();
		$config["autoload"]["plugins"]	= array();


	/* Database connection */
		$config["db"] = array(
			"host"		=> "localhost",
			"user"		=> "root",
			"password"	=> "",
			"name"		=> "catacombsnatch"
		);


?>
