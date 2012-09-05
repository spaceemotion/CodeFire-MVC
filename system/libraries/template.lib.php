<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Template class
	 *
	 * Manages all view output and custom template variables.
	 *
	 * @package libraries
	 * @version 1.0
	 */
	class CF_Template {
		protected $_page_title = "";

		protected $_vars = array();
		protected $_header = array();

		protected $_js	 = array();
		protected $_css	 = array();
		protected $_meta = array();

		protected static $_file_label = "{F}";
		protected static $_code_label = "{C}";


		public function __construct() {
			$this->include_meta("generator", "CodeFire ".CF_VERSION);
		}

		public function set($name, $value) {
			$this->_vars[$name] = $value;
		}

		public function set_header($name, $content) {
			$this->_header[$name] = $content;
		}

		public function write($view_path = null, $data = array(), $render_header = true, $tpl = null) {
			/* Send the headers */
				foreach($this->_header as $name => $content)
					header("$name: $content");


			/* Get all vars as class variables */
				if(is_array($data) && count($data) > 0)
					array_merge($this->_vars, $data);

				if(count($this->_vars) > 0)
					extract($this->_vars);


			/* Page content using buffered output */
				if($view_path != null) {
					$content = null;

					if (file_exists(APP_VIEW . $view_path. '.php')) {
						ob_start();

						include (APP_VIEW . $view_path. '.php');

						$content = ob_get_contents();
						ob_end_clean();
					}
				} else {
					$content = $data;
				}


			/* Page templating */
				if($content != null) {
					if(!$tpl) $tpl = getConfigItem("site.default_template");

					$_file = APP_TEMPLATE.$tpl.DS."index.php";
					
					if(file_exists($_file)) include $_file;
				}

		}

		public function set_data($data = array() ) {
			if(!empty($data)) {
				foreach($data as $key => $var) $this->_vars[$key] = $var;
			}
		}

		public function set_title($title) {
			$this->_page_title = $title;
		}

		protected function get_title() {
			$title = getConfigItem("site.title");
			return $this->_page_title.(!empty($title) ? " - $title" : "");
		}

		public function include_meta($name, $content) {
			$this->_meta[$name] = $content;
		}

		public function include_code($type, $file_path, $file = true) {
			array_push(
				$this->${"_".$type},
				$file ? self::$_file_label.$file_path : self::$_code_label.$file_path
			);
		}

		protected function get_meta() {
			$return = "";

			if(!empty($this->_meta)) {
				foreach($this->_meta as $name => $content)
					$return .= "<meta name=\"$name\" content=\"$content\" />\n";
			}

			return $return;
		}

		protected function get_css() {
			$return = "";

			if(!empty($this->_css)) {
				foreach($this->_css as $css) {
					if(substr($css, 0, strlen(self::$_file_label)) == self::$_file_label)
						$return .= '<link rel="stylesheet" type="text/css" href="'.ltrim($css, self::$_file_label)."\">\n";
					else if(substr($css, 0, strlen(self::$_code_label)) == self::$_code_label)
						$return .= '<style type="text/css">'.ltrim($css, self::$_code_label)."</style>\n";
					else
						$return .= "$css\n";
				}
			}

			return $return;
		}

		protected function get_javascript() {
			$return = "";

			if(!empty($this->_js)) {
				foreach($this->_js as $js) {
					if(substr($js, 0, strlen(self::$_file_label)) == self::$_file_label)
						$return .= '<script type="text/javascript" src="'.ltrim($js, self::$_file_label)."\"></script>\n";
					else if(substr($js, 0, strlen(self::$_code_label)) == self::$_code_label)
						$return .= '<script type="text/javascript">'.ltrim($js, self::$_code_label)."</script>\n";
					else
						$return .= "$js\n";
				}
			}

			return $return;
		}

	}


?>
