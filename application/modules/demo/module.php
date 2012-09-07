<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Demo_module main class
	 *
	 * @version 1.0
	 */

	class Demo_Module extends CF_Module {
		public function render() {
			return "<p>Modules are classes that give output like controllers. They have no modeland
				no templated output.<br />
				<strong>Example:</strong> You want to have a last post feed on your main page and on subpages too.
				Instead of trying to code some workarounds just put that feed code into a module
				and load it when you need it!</p>";
		}
	}


?>
