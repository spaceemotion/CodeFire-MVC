<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Demo model to test the system functionality
	 */

	class Demo_Model extends CF_Model {
		public function display_demo() {
			return "Welcome to the <em>CodeFire</em> demo page. If you are seeing this, the system was installed and configured correctly!";
		}
	}
?>
