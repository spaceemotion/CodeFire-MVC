<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Demo model to test the system functionality
	 */

	class Demo_Model extends CF_Model {
		public function display_demo() {
			return "Welcome to the <em>CodeFire</em> demo page. If you are seeing this, the system has been installed and configured correctly!
				To start off you can delete the demo files or edit them right away.";
		}
	}
?>
