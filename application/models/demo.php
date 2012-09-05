<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Demo model to test the system functionality
	 */

	class Demo_Model extends CF_Model {
		public function display_demo() {
			return "<h2>It's alive!</h2>";
		}
	}
?>
