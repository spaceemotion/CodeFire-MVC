<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Basic controller class
	 *
	 * @package core
	 * @version 1.0
	 */
	class CF_Controller {
		protected $template;

		protected $_render;
		protected $_render_header = true;


		public function __construct() {
			$this->load =& load_class('loader', 'core');
			$this->template =& load_class("template");
		}

		/**
		 * Sends the render data to the template instance which
		 * will render the site
		 */
		public function __destruct() {
			if($this->_render) $this->template->render($this->_render_header);
		}
	}


?>
