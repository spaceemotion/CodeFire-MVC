<?php

	/**
	 * index.php
	 *
	 * Main index file that runs the whole site and defines
	 * the basic directories.
	 *
	 * @version	1.0
	 */


	/* Basic Constant Defines */
		define("SYSTEM_START", microtime());

		define('DS',		DIRECTORY_SEPARATOR);
		define("BASE_DIR",	dirname(__FILE__).DS);


	/* Require Standard Functions and files */
		require_once BASE_DIR."system".DS."libraries".DS."defines.lib.php";
		require_once SYSTEM."config.php";
		require_once SYSTEM_CORE."common.php";
		require_once SYSTEM_CORE."codefire.php";


	/* Start the whole thingy */
		run_codefire();


?>