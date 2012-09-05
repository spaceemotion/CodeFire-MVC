<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Demo controller to test the system functionality
	 */
	class Demo_Controller extends CF_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model("demo");
		}

		function index() {
			$data = "<h1>CodeFire Demo content</h1>";
			$data .= $this->demo_model->display_demo();
			$data .= "Page generated in {{ELAPSED_TIME}} seconds";

			$this->template->write(null, $data);
		}

		function no_template($request = "") {
			// DEMO OUTPUT WITHOUT TEMPLATE
			echo "<h1>Request handler</h1>";
			echo $this->demo_model->display_demo();

			echo "You requested $request<br />Page generated in {{ELAPSED_TIME}} seconds";
		}
	}

?>
