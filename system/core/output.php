<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Output class
	 *
	 * Parses the output and sends it to the browser
	 *
	 * @package libraries
	 * @version 1.0
	 */
	class CF_Output {
		/**
		 * Stores the final output sent to the site
		 *
		 * @var String
		 */
		protected $_out;

		protected $_parse_vars = true;

		/**
		 * An array storing variables to replace when parsing
		 * the site output
		 *
		 * @var array
		 */
		protected $_parse_array = array();


		protected $_headers = array();

		/**
		 * Stores common error codes and their belonging
		 * error text
		 *
		 * @var array
		 */
		public static $error_codes = array(
			/* 1xx Errors */
            100 => 'Continue',
            101 => 'Switching Protocols',

			/* 2xx Errors */
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',

			/* 3xx Errors */
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',

			/* 4xx Errors */
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',

			/* 5xx Errors */
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );


		/**
		 * Get the stored output
		 *
		 * @return string
		 */
		public function get_output() {
			return $this->_parse_vars ? $this->parse($this->_out) : $this->_out;
		}

		/**
		 * Set the output
		 *
		 * @param string $out
		 * @return \CF_Output
		 */
		public function set_output($out) {
			$this->_out = $out;

			return $this;
		}


		/**
		 * Append to site output
		 *
		 * @param string $out
		 * @return \CF_Output
		 */
		public function append($out) {
			if (empty($this->_out))
				$this->_out = $out;
			else
				$this->_out .= $out;

			return $this;
		}

		/**
		 * Set the site header
		 *
		 * @param int	 $code
		 * @param string $content
		 */
		public function setStatusHeader($code, $content = '') {
			/* Error checking and content setting */
				if ($code == '' || !is_numeric($code))
					show_error('Status code not numeric', 500);

				if (isset(self::$error_codes[$code]) && $content == '')
					$content = self::$error_codes[$code];

				if ($content == '')
					show_error('No status text available.', 500);

			/* Get the server protocol */
				$server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : false;

			/* Set the header */
				header($server_protocol." $code $content", true, $code);
		}

		private function parse($content) {
			/* General setting of environment variables */
				$this->_parse_array["ELAPSED_TIME"] = microtime() - SYSTEM_START;

			/* Replace loop */
				foreach($this->_parse_array as $var => $replace) {
					$content = str_replace('{{'.$var.'}}', $replace, $content);
				}


			/* Return the content */
				return $content;
		}
	}


?>
