<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * codefire.php
	 *
	 * CodeFire main file to run the site
	 *
	 * @package core
	 * @version 1.0
	 */

	global $config;


	/* Set execution start */
		$config["SYSTEM_START"] = microtime_float();

	/* Set the default reporting method */
		if (getConfigItem("site.production") == false) {
			error_reporting(E_ALL);
			ini_set('display_errors','On');

		} else {
			error_reporting(E_ALL);
			ini_set('display_errors','Off');
			ini_set('log_errors', 'On');
			ini_set('error_log', TEMP_LOGS.'error_log');
		}

	/* Default timezone */
		date_default_timezone_set(getConfigItem("site.time_zone", "UTC"));

	/* Get urls and request method */
		$url = isset($_GET['url']) ? trim($_GET['url'], "/") : getConfigItem("route.default_page", "");
		$config["site"]["request_url"] = $url;

		$split_url = explode("/", trim($url, "/"));
		$count_url = count($split_url);

	/* Check if cache is be enabled and display cached data */
		$cache_enabled = getConfigItem("cache.enabled", true);

		if($cache_enabled) {
			$CF_cache =& load_class("cache", "core");

			$cache = $CF_cache->read_cached_file($url);

			if(!empty($cache)) {
				$CF_output =& load_class("output", "core");

				switch($CF_cache->get_level()) {
					case 1:
						$CF_template =& load_class("template");

						$CF_template->set_title($cache["title"], false);

						foreach($cache["header"] as $key => $val)
							$CF_template->set_header($key, $val);

						foreach($cache["meta"] as $key => $val)
							$CF_template->set_meta($key, $val);

						foreach($cache["css"] as $css) {
							if(substr($css, 0, strlen($CF_template::$_file_label)) == $CF_template::$_file_label)
								$CF_template->include_code("css", $css, true);
							else if(substr($css, 0, strlen($CF_template::$_code_label)) == $CF_template::$_code_label)
								$CF_template->include_code("css", $css, false);
						}

						foreach($cache["js"] as $js) {
							if(substr($js, 0, strlen($CF_template::$_file_label)) == $CF_template::$_file_label)
								$CF_template->include_code("js", $js, true);
							else if(substr($js, 0, strlen($CF_template::$_code_label)) == $CF_template::$_code_label)
								$CF_template->include_code("js", $js, false);
						}

						$CF_template->set_data($cache["vars"]);

						ob_start();
						$CF_template->write(
							$cache["view"],
							$cache["data"],
							$cache["tpl"],
							false);
						$cache = ob_get_contents();
						ob_end_clean();

					case 2:
						exit($CF_output->set_output($cache)->get_output());

					default:
						break;
				}
			}
		}

	/* Load controller */
		$file = APP_CONTROLLER.strtolower($split_url[0]).".php";

		if(file_exists($file)) {
			load_class("controller", "core");

			include_once $file;

			$class_name = ucfirst($split_url[0]."_Controller");
			if(class_exists($class_name)) {
				/* Start the buffered output */
					ob_start();
					$controller = new $class_name();

					if($count_url > 1)
						$method_name = $split_url[1];
					else
						$method_name = "index";


					/* Call class method or display 404 error */
						if (!in_array(strtolower($method_name), array_map('strtolower', get_class_methods($controller))))
							load_class('Error', 'core')->display_404();

						call_user_func_array(array(&$controller, $method_name), array_slice($split_url, 2));

				/* Get the output */
					$out = ob_get_contents();
					ob_end_clean();

				/* Load the output class and write cache file */
					if(!empty($out)) {
						$CF_output =& load_class("output", "core");
						$CF_output->set_output($out);

						$result = $CF_output->get_output();

						if($cache_enabled && $CF_cache->get_level() > 1)
							$CF_cache->save_cached_file($url, $result);

						exit($result);
					}
			}
		}

	/* Display error page when no content was sent */
		if(getConfigItem("site.nocontent404", true))
			load_class('Error', 'core')->display_404();


?>
