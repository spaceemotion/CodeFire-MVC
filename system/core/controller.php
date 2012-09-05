<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Basic controller class
	 *
	 * @package core
	 * @version 1.0
	 */
	class CF_Controller {
		/**
		 * Used for dynamic loading of models and plugins
		 *
		 * @var \CF_Controller
		 */
		private static $_instance;


		public function __construct() {
			self::$_instance =& $this;

			$this->load =& load_class('loader', 'core');
			$this->template =& load_class('template');
		}

		public static function &get_instance() {
			return self::$_instance;
		}
	}


?>
