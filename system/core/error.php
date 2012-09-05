<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Error handling class
	 *
	 * @package core
	 * @version 1.0
	 */
	class CF_Error {
		/**
		 * Level of the output buffering.
		 *
		 * @var int
		 */
		protected $_ob_level;


		public function __construct() {
			$this->_ob_level = ob_get_level();
		}

		/**
		 * Shows an error message
		 *
		 * The message can be shown with a template located in 'system/templates'
		 *
		 * @param string $title
		 * @param string $msg
		 * @param string $tpl
		 * @param int	 $error_code
		 *
		 * @return string
		 */
		public function display_error($title, $msg, $tpl = 'general', $error_code = 500) {
			/* Set the site status to the latest error */
				load_class("output", "core")->setStatusHeader($error_code);

			/* Implode the error message(s) */
				$msg = '<p>'.implode('</p><p>', !is_array($msg) ? array($msg) : $msg).'</p>';


			/* Flush previous ob layers */
				if (ob_get_level() > $this->_ob_level + 1)
					ob_end_flush();


			/* Use buffered output to echo the error */
				$file = SYSTEM_TEMPLATE.$tpl.'.error.php';

				if(file_exists($file)) {
					ob_start();

					include $file;

					$buffer = ob_get_contents();
					ob_end_clean();

					return $buffer;
				}

			/* No template found, return the default format */
				return "<h1>$error_code: $title</h1>$msg";
		}

		public function display_404($page = "") {
			exit($this->display_error("Page Not Found", "The page you requested could not be found.", 'general', 404));
		}
	}


?>
