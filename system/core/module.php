<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Module class
	 *
	 * Abstract implementation of a module class.
	 * Modules are some kind of a mini-site. They have no model
	 * and no templated output.
	 *
	 * Example: You want to have a last post feed on your main
	 * page and on subpages too. Instead of trying to code some
	 * workarounds just put that feed code into a module and load
	 * it when you need it!
	 *
	 * @package core
	 * @version 1.0
	 */

	class CF_Module {
		/**
		 * Execute and run the module
		 */
		public function render() {}
	}


?>
