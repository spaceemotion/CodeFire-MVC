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
	 * Get the loaded controller instance
	 *
	 * Used by the loader class for dynamic model and
	 * plugin loading (Singleton-model)
	 *
	 * @return \CF_Controller
	 */
	function get_instance() {
		return CF_Controller::get_instance();
	}


	/**
	 * Keeps track of which libraries have been loaded.
	 *
	 * @param	string $class_name the class name
	 * @return	array
	 */
	function is_loaded($class_name = '') {
		static $loaded = array();

		if (!empty($class_name))
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
	 * @param	string $class_name	the class name
	 * @param	string $dir			the directory
	 * @param	string $prefix		the class name prefix
	 * @return	object	the class instance
	 */
	function &load_class($class_name, $dir = 'libraries', $prefix = 'CF_') {
		static $classes = array();

		$class_name = strtolower($class_name);


		/* Check for class existence */
			if (isset($classes[$class_name]))
				return $classes[$class_name];

		$name = false;


		/* Look through the application folder first, then use thesystem folder */
			foreach (array(APPLICATION, SYSTEM) as $path) {
				$file_path = $path.$dir.DS.$class_name.(($dir == "libraries") ? ".lib" : "").".php";

				if (file_exists($file_path)) {
					$name = $prefix.$class_name;

					if (!class_exists($name)) require($file_path);
					else break;
				}
			}


		/* Load user classes */
			$full_name = getConfigItem("site.userclass_prefix").$class_name;

			if (file_exists(APPLICATION.$dir.DS.$full_name.".php")) {
				$name = $full_name;

				if(!class_exists($full_name)) require(APPPATH.$dir.DS.$full_name.'.php');
			}


		/* Exit when no class could be located */
			if (!$name) exit("Unable to locate class '$class_name'");


		/* Otherwise return the class */
			is_loaded($class_name);

			$classes[$class_name] = new $name();
			return $classes[$class_name];
	}

	/**
	 * Loads a database using a given configuration name
	 * The full configuration is placed in the config.php
	 *
	 * @param string $config
	 * @return \CF_DB
	 */
	function load_database($config = 'default') {
		is_loaded("db_".$config);
	}

	/**
	 * Returns a configuration value based on the path. By default
	 * the delimiter is '.'
	 *
	 * Example:
	 * $config["site"]["title"] = "My site title";
	 * getConfigVar("site.title")
	 *
	 * Returns: "My site title"
	 *
	 * @param string $path		the path string
	 * @param string $default	the default value to return
	 * @param string @delimiter	the delimiter to use for the path
	 */
	function getConfigItem($path, $default = null, $delimiter = '.') {
		global $config;

		if(!is_string($path))
			return;

		$arr = explode($delimiter, $path);

		/* Only one level, so we can return instantly */
			if(count($arr) == 1)
				return $config[$arr[0]];


		/* More than one level, lets build the search
		 * string to access the values */
			$pointer = $config;

			foreach ($arr as $a) {
				if (!isset($pointer[$a]))
					return $default;

				$pointer = $pointer[$a];
			}


		/* Return the stuff */
			return $pointer;
	}

	/**
	 * Common function to display an error message
	 *
	 * @param string $msg
	 * @param int	 $error_code
	 * @param string $title
	 */
	function show_error($msg, $error_code = 500, $title = 'An Error Has Occured') {
		exit(load_class('Error', 'core')->display_error($title, $msg, 'general', $error_code));
	}


	/**
	 * Sometimes microtime() can return negative values, which
	 * is very contrapoductive when calculating the elapsed time
	 *
	 * @return float
	 */
	function microtime_float() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

?>
