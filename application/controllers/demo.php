<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Description of demo
	 *
	 * @author SpaceEmotion
	 */
	class Demo_Controller extends CF_Controller {
		public function __construct() {
			parent::__construct();

			$this->_render = true;
		}
	}

?>
