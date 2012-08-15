<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * bootstrap.php
	 *
	 * Bootstrap class
	 *
	 * @package core
	 * @version 1.0
	 */
	class CodeFire {
		public function run() {
			global $config;

			/* Set the default reporting method */
				$this->setReporting();

			/* Default timezone */
				if($config["site"]["time_zone"] != null)
					date_default_timezone_set($config["site"]["time_zone"]);

			/* Get urls and request method */
				$url = isset($_GET['url']) ? $_GET['url'] : "";
				$config["site"]["request_url"] = $url;

				$split_url = explode("/", trim($url, "/"));
				$count_url = count($split_url);

			/* Load controller */
				if(empty($split_url[0])) {
					$split_url = array($config["route"]["default_controller"]);
					$count_url = 1;
				}

				$file = APP_CONTROLLER.strtolower($split_url[0]).".php";

				if(file_exists($file)) {
					load_class("controller", "core");
					
					include_once $file;

					$class_name = ucfirst($split_url[0]."_Controller");
					if(class_exists($class_name)) {
						$controller = new $class_name();

					}
				}
		}

		/**
		 * Check if environment is development and display errors either
		 * on screen or in a logfile
		 */
		private function setReporting() {
			global $config;

			if ($config["site"]["production"] == false) {
				error_reporting(E_ALL);
				ini_set('display_errors','On');

			} else {
				error_reporting(E_ALL);
				ini_set('display_errors','Off');
				ini_set('log_errors', 'On');
				ini_set('error_log', TEMP_LOGS.'error.log');
			}
		 }
	 }


?>
