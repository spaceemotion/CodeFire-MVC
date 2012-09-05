<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * defines.lib.php
	 *
	 * Defines basic directory constants for the system and
	 * the user application
	 *
	 * @package libraries
	 * @version 1.0
	 */


	/* Temp file constants */
		define("TEMP",			BASE_DIR	 ."tmp".DS);
		define("TEMP_CACHE",	TEMP		 ."cache".DS);
		define("TEMP_LOGS",		TEMP		 ."logs".DS);


	/* System constants */
		define("SYSTEM",		 BASE_DIR	 ."system".DS);
		define("SYSTEM_CORE",	 SYSTEM		 ."core".DS);
		define("SYSTEM_TEMPLATE",SYSTEM		 ."templates".DS);
		define("SYSTEM_LIB",	 SYSTEM		 ."libraries".DS);
		define("SYSTEM_HELPER",  SYSTEM_LIB	 ."helpers".DS);
		define("SYSTEM_PLUGIN",  SYSTEM_LIB	 ."plugins".DS);


	/* Application constants */
		define("APPLICATION",	 BASE_DIR	 ."application".DS);
		define("APP_CONTROLLER", APPLICATION ."controllers".DS);
		define("APP_MODEL",		 APPLICATION ."models".DS);
		define("APP_VIEW",		 APPLICATION ."views".DS);
		define("APP_TEMPLATE",	 APPLICATION ."templates".DS);
		define("APP_MODULE",	 APPLICATION ."modules".DS);
		define("APP_LIB",		 APPLICATION ."libraries".DS);
		define("APP_PLUGIN",	 APP_LIB	 ."plugins".DS);
		define("APP_HELPER",	 APP_LIB	 ."helper".DS);


	/* Custom constants */
		define("CF_VERSION",	 "1.0");


?>
