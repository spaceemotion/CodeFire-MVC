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
			$this->template->set_title("Demo site");

			$data = "<h1>CodeFire Demo content</h1>";
			$data .= $this->demo_model->display_demo();
			$data .= "Page generated in {{ELAPSED_TIME}} seconds; ".  getConfigItem("site.request_url");

			$this->template->write(null, $data);
		}

		function no_template($request = "") {
			// DEMO OUTPUT WITHOUT TEMPLATE
			echo "<h1>Request demo</h1>";
			echo $this->demo_model->display_demo();

			echo "You requested $request<br />Page generated in {{ELAPSED_TIME}} seconds";
		}
	}

?>
