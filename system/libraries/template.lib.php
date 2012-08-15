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

		protected $_js	 = array();
		protected $_css	 = array();
		protected $_meta = array();


		public function __construct() {
			$this->includeMeta("generator", "CodeFire ".CF_VERSION);
		}

		public function set($name, $value) {
			$this->_vars[$name] = $value;
		}

		public function render($view_path = null, $render_header = true) {
			/* Get all vars as class variables */
				extract($this->_vars);

			/* Page header */
				if($render_header) {
					$header_path = APP_TEMPLATE."header.php";

					if(file_exists($header_path)) include $header_path;
				}

			/* Page content */
				if (file_exists(APP_VIEW . $view_path. '.php')) include (APP_VIEW . $view_path. '.php');

			/* Page footer */
				if($render_header) {
					$footer_path = APP_TEMPLATE."footer.php";

					if(file_exists($footer_path)) include $footer_path;
				}
		}

		public function setData($data = array() ) {
			if(!empty($data)) {
				foreach($data as $key => $var) $this->_vars[$key] = $var;
			}
		}

		public function setTitle($title) {
			$this->_page_title = $title;
		}

		public function includeMeta($name, $content) {
			$this->_meta[$name] = $content;
		}

		public function includeHeader($type, $file_path, $file = true) {
			$type = "_$type";

			array_push($this->$type, ($file ? "FILE:" : "CODE:").$this->_replace_paths($file_path));
		}

		protected function _replace_paths($file_path) {
			foreach(array (
				"template" => APP_TEMPLATE,
				"root" => $GLOBALS["config"]["site"]["url"].DS
			) as $key => $var) {
				str_replace('{'.$key.'}', $var, $file_path);
			}

			return $file_path;
		}

		protected function getHeader() {
			$header = "";

			/* Title tag */
				$title = $GLOBALS["config"]["site"]["title"];
				$header .= "<title>{$this->_page_title}".(!empty($title) ? " - $title" : "")."</title>\n";


			/* Meta tags */
				if(!empty($this->_meta)) {
					$header .= "\n";

					foreach($this->_meta as $name => $content)
						$header .= "<meta name=\"$name\" content=\"$content\" />\n";
				}


			/* CSS code */
				if(!empty($this->_css)) {
					$header .= "\n";

					foreach($this->_css as $css) {
						if(substr($css, 0, strlen("FILE:")) == "FILE:")
							$header .= '<link rel="stylesheet" type="text/css" href="'.ltrim($css, "FILE:")."\">\n";
						else if(substr($css, 0, strlen("CODE:")) == "CODE:")
							$header .= '<style type="text/css">'.ltrim($css, "CODE:")."</style>\n";
						else
							$header .= "$css\n";
					}
				}


			/* JavaScript stuff */
				if(!empty($this->_css)) {
					$header .= "\n";

					foreach($this->_js as $js) {
						if(substr($js, 0, strlen("FILE:")) == "FILE:")
							$header .= '<script type="text/javascript" src="'.ltrim($js, "FILE:")."\"></script>\n";
						else if(substr($js, 0, strlen("CODE:")) == "CODE:")
							$header .= '<script type="text/javascript">'.ltrim($js, "CODE:")."</script>\n";
						else
							$header .= "$js\n";
					}
				}


			/* Return the generated header */
				return $header;
		}

	}


?>
