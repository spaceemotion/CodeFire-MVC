<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Loader class to load views and files
	 *
	 * @package core
	 * @version 1.0
	 */
	class CF_Loader {
		/* Path variables */
		protected $_lib_paths	 = array();
		protected $_helper_paths = array();
		protected $_model_paths	 = array();
		protected $_view_paths	 = array();

		/* Class instances */
		protected $_classes		 = array();
		protected $_models		 = array();
		protected $_helpers		 = array();

		/**
		 * List of loaded files
		 *
		 * @var array
		 * @access protected
		 */
		protected $_loaded		 = array();


		public function __construct() {
			$this->_lib_paths		= array(APP_LIB, SYSTEM_LIB);
			$this->_helper_paths	= array(APP_HELPER, SYSTEM_HELPER);
			$this->_model_paths		= array(APP_MODEL);
			$this->_view_paths		= array(APP_VIEW);

			$this->_autoload();
		}


		/**
		 * Autoloads the classes defined in the autoload config
		 * array.
		 *
		 * @return void
		 */
		protected function _autoload() {
			global $config;

			$auto_load =& $config["autoload"];

			if (!array($auto_load) || empty($auto_load))
				return;


			/* Autoload helpers */
				foreach (array('helper') as $type) {
					if (isset($auto_load[$type]) && count($auto_load[$type]) > 0 )
						$this->$type($auto_load[$type]);
				}
		}
	}


?>