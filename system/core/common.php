<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * common.php
	 *
	 * Base functions for the framework
	 *
	 * @package core
	 * @version 1.0
	 */


	/**
	 * Keeps track of which libraries have been loaded.
	 *
	 * @param	string	the class name
	 * @return	array
	 */
	function is_loaded($class_name = '') {
		static $loaded = array();

		if ($class_name != '')
			$loaded[strtolower($class_name)] = $class_name;

		return $loaded;
	}


	/**
	 * Class registering
	 *
	 * If the requested class does not exist the function will search
	 * for it and set it to a static variable. If it already has been
	 * instantiated the variable is returned instead.
	 *
	 * @param	string	the class name
	 * @param	string	the directory
	 * @param	string	the class name prefix
	 * @return	object	the class instance
	 */
	function &load_class($class_name, $dir = 'libraries', $prefix = 'CF_') {
		global $config;
		static $classes = array();

		$name = false;
		$class_name = strtolower($class_name);


		/* Check for class existence */
			if (isset($classes[$class_name]))
				return $classes[$class_name];


		/* Look through the application folder first, then use thesystem folder */
			foreach (array(APPLICATION, SYSTEM) as $path) {
				$file_path = $path.$dir.DS.$class_name.(($dir == "libraries") ? ".lib" : "").'.php';

				if (file_exists($file_path)) {
					$name = $prefix.$class_name;

					if (!class_exists($name)) require($file_path);
					else break;
				}
			}


		/* Load user classes */
			$full_name = "{$config["site"]["userclass_prefix"]}$class_name";

			if (file_exists(APPLICATION.$dir.DS.$full_name.".php")) {
				$name = $full_name;

				if(!class_exists($full_name)) require(APPPATH.$dir.DS.$full_name.'.php');
			}


		/* Exit when no class could be located */
			if (!$name) exit("Unable to locate class '$class_name.php'");


		/* Otherwise return the class */
			is_loaded($class_name);

			$classes[$class_name] = new $name();
			return $classes[$class_name];
	}


?>
