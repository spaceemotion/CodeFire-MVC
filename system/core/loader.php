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
		protected $_modules		 = array();
		protected $_databases	 = array();

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
				$this->apply_batch('model', $model);

			/* Check if the model is placed in a sub-folder */
				$path = $this->apply_subdir($model);

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

			show_error("Could not find model '$model'".(!empty($path) ? " in '$path'" : ''));
		}

		/**
		 * Loads a database based on a configuration name
		 * The configuration data is placed in the config.php
		 * file.
		 *
		 * @param string $config
		 */
		public function database($config = 'default') {
			/* Check if database is already loaded (has been connected to) */
				if(in_array($config, $this->_databases))
					return $this->_databases[$config];

			/* Load another database instance */
				$db_config = $GLOBALS["db"][$config];

				if(!empty($db_config)) {

					require_once SYSTEM.'database'.DS.'database.php';

					if(!class_exists('CF_Database'))
						show_error("Could not load database: database class not found!");

					$db = new CF_Database(
						$db_config["type"],
						$db_config["host"],
						$db_config["user"],
						$db_config["passwd"],
						$db_config["name"],
						$db_config["port"]);

					$this->_databases[$config] =& $db;

					return $db;
				}

			show_error("No correct database configuration for '$config' found! Please make sure that the specified configuration exist!");
		}

		public function module($module, $name = null) {
			/* Are we loading more than one module? */
				$this->apply_batch('module', $module);

			/* Check if the module is already loaded */
				if (!$name) $name = $module."_module";

				if (in_array($name, $this->_modules, true)) return;

				$controller =& get_instance();

				if (isset($controller->$name))
					return;

			/* Get the model */
				foreach ($this->_module_paths as $m_path) {
					$file_path = $m_path.$module.DS.'module.php';

					if (file_exists($file_path)) {
						if (!class_exists('CF_Module'))
							load_class('module', 'core');

						require_once $file_path;

						$module = ucfirst($module)."_Module";

						$module_class = new $module;
						$this->_models[] =& $module_class;
						
						return $module_class;
					}
				}

			show_error("Could not find module '$module'".(!empty($path) ? " in '$path'" : ''));
		}

		public function helper($helper) {
			/* Are we loading more than one helper? */
				$this->apply_batch('helper', $helper);

			/* Check if the helper is placed in a sub-folder */
				$path = $this->apply_subdir($helper);

			/* Include the helper */
				foreach($this->_helper_paths as $h_path) {
					$file_path = $h_path.$path.$helper.'.php';

					if(file_exists($file_path)) {
						include_once $file_path;
						return;
					}
				}

			var_dump($this->_helper_paths);
			show_error("Could not find helper '$helper'".(!empty($path) ? " in '$path'" : ''));
		}

		private function apply_batch($func, $array) {
			if (is_array($array)) {
				foreach ($array as $obj)
					$this->$func($obj);

				return;
			} else if($array == '') return;
		}

		private function apply_subdir(&$obj) {
			$path = "";

			if (($slash = strrpos($obj, "/")) != false) {
				$path = substr($obj, 0, $slash + 1);
				$obj =& substr($obj, $slash + 1);
			}

			return $path;
		}
	}


?>