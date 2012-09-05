<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * codefire.php
	 *
	 * CodeFire main class to run the site
	 *
	 * @package core
	 * @version 1.0
	 */
	class CodeFire {
		public function run() {
			/* Set the default reporting method */
				$this->set_reporting();

			/* Default timezone */
				date_default_timezone_set(getConfigItem("site.time_zone", "UTC"));

			/* Get urls and request method */
				$url = isset($_GET['url']) ? trim($_GET['url'], "/") : "";
				$GLOBALS["config"]["site"]["request_url"] = $url;

				if(empty($url)) $url = getConfigItem("route.default_page");

				$split_url = explode("/", trim($url, "/"));

				$count_url = count($split_url);

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

							if($count_url > 1) {
								$method_name = $split_url[1];
							} else {
								$method_name = "index";
							}


							/* Call class method or display 404 error */
								if (!in_array(strtolower($method_name), array_map('strtolower', get_class_methods($controller))))
									load_class('Error', 'core')->display_404();

								call_user_func_array(array(&$controller, $method_name), array_slice($split_url, 2));


						/* Get the output */
							$out = ob_get_contents();
							ob_end_clean();


						/* Load the output class */
							if(!empty($out)) {
								$CF_output = load_class("output", "core");
								$CF_output->set_output($out);

								exit($CF_output->get_output());
							}
					}
				}

			/* Display error page when no content was sent */
				if(getConfigItem("site.nocontent404", true))
					load_class('Error', 'core')->display_404();
		}

		/**
		 * Check if environment is development and display errors either
		 * on screen or place into a logfile
		 */
		private function set_reporting() {
			if (getConfigItem("site.production") == false) {
				error_reporting(E_ALL);
				ini_set('display_errors','On');

			} else {
				error_reporting(E_ALL);
				ini_set('display_errors','Off');
				ini_set('log_errors', 'On');
				ini_set('error_log', TEMP_LOGS.'error_log');
			}
		 }
	 }


?>
