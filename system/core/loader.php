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
		protected $_module_paths = array();

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
			$this->_module_paths	= array(APP_MODULE);

			$this->_autoload();
		}


		/**
		 * Autoloads the classes defined in the autoload config
		 * array.
		 *
		 * @return void
		 */
		protected function _autoload() {
			$auto_load =& getConfigItem("autoload");

			if (!array($auto_load) || empty($auto_load))
				return;


			/* Autoload helpers */
				foreach (array('helper', 'model') as $type) {
					if (isset($auto_load[$type]) && count($auto_load[$type]) > 0 )
						$this->$type($auto_load[$type]);
				}
		}

		public function model($model, $name = null) {
			/* Are we loading more than one model? */
				if (is_array($model)) {
					foreach ($model as $m)
						$this->model($m);

					return;
				} else if($model == '') return;


			/* Check if the model is placed in a sub-folder */
				$path = "";

				if (($slash = strrpos($model, "/")) != false) {
					$path = substr($model, 0, $slash + 1);
					$model = substr($model, $slash + 1);
				}

			/* Check if the model is already loaded */
				if (!$name) $name = $model."_model";

				if (in_array($name, $this->_models, true)) return;

				$controller =& get_instance();

				if (isset($controller->$name))
					return;


			/* Get the model */
				foreach ($this->_model_paths as $m_path) {
					$file_path = $m_path.$path.$model.'.php';

					if (file_exists($file_path)) {
						if (!class_exists('CF_Model'))
							load_class('model', 'core');

						require_once $file_path;

						$model = ucfirst($model)."_Model";

						$controller->$name = new $model;

						$this->_models[] = $name;
						return;
					}
				}

			// TODO: throw an error in here
		}

		public function database() {
			
		}
	}


?>