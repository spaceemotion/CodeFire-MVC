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

			$data["title"] = "<em>CodeFire</em> Demo content";
			$data["text"] = $this->demo_model->display_demo();
			$data["footer"] = "Page generated in {{time_elapsed}} seconds using {{memory_usage}} - Requested site: ".  getConfigItem("site.request_url");
			$data["sidebar"] = "";

			$this->template->write("basic", $data);
		}

		function no_template($request = "") {
			// DEMO OUTPUT WITHOUT TEMPLATE
			echo "<h1>Request demo</h1>";
			echo $this->demo_model->display_demo();

			echo "<p>Please mind that no templated output only can be cached if the cache level is set to <code>2</code></p>
			<p>Additional request data: $request</p>Page generated in {{time_elapsed}} seconds using {{memory_usage}}";
		}
	}

?>
