<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * cache.php
	 *
	 * System cache class
	 *
	 * @package core
	 * @version 1.0
	 */
	class CF_Cache {
		/**
		 * Stores the maximum elapsed time until a site will be
		 * cached again
		 *
		 * @var int
		 */
		protected $_time;

		/**
		 * The directory to write the files into
		 *
		 * @var string
		 */
		protected $_directory;

		/**
		 * Cache write level
		 *
		 * @var int
		 */
		protected $_level;


		public function __construct() {
			/* Get cache time and convert it to minutes */
				$this->_time = getConfigItem("cache.time")*60;

			/* Get cache directory from config */
				$this->_directory = getConfigItem("cache.directory");

			/* Get cache level from config */
				$this->_level = getConfigItem("cache.level");

			/* Check if cache directory is writable */
				if(!is_writable($this->_directory))
					show_error("Cache directory must be writable!");
		}


		/**
		 * Return cache write level
		 *
		 * @return int
		 */
		public function get_level() {
			return $this->_level;
		}


		/**
		 * Reads a cached file based on the request url
		 * and executes it.
		 *
		 * @param string $request_url
		 * @return string
		 */
		public function read_cached_file($request_url) {
			$file_path = $this->get_file_path($request_url);

			if ($this->is_available($request_url))
				return unserialize(file_get_contents($file_path));

			return null;
		}


		/**
		 * Saves content to cached file and returns true on success
		 *
		 * @param string $request_url
		 * @param string $content
		 * @return boolean
		 */
		public function save_cached_file($request_url, $content) {
			$file_path = $this->get_file_path($request_url);

			$handler = fopen($file_path, 'w+');

			if($handler) {
				if (flock($handler, LOCK_EX)) {
					ftruncate($handler, 0);

					if(!is_array($content["data"])) {
						$content["data"] = $this->trim_whitespace($content["data"]);
					} else {
						foreach($content["data"] as &$d)
							$d = $this->trim_whitespace($d);
					}

					$output = serialize($content);

					fwrite($handler, $output);
					fclose($handler);
				}

				return true;
			}

			return false;
		}

		/**
		 * Returns true if the requested url is available as
		 * cache file (and the elapsed time limit has been reached)
		 *
		 * @param type $request_url
		 * @return boolean
		 */
		public function is_available($request_url) {
			$file_path = $this->get_file_path($request_url);

			return (file_exists($file_path) && time() - $this->_time < filemtime($file_path));
		}


		/**
		 * Private function to calculate the file path of
		 * a request_url
		 *
		 * @param string	$request_url
		 * @param boolean	$append_level
		 * @return string
		 */
		private function get_file_path($request_url, $append_level = true) {
			$file_name = urlencode($request_url)."-".md5($request_url);

			return  TEMP_CACHE.($append_level ? $this->_level."-" : '').$file_name.'.cache';
		}

		private function trim_whitespace($str) {
			return preg_replace(
				array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s'),
				array('>','<','\\1'),
				$str
			);
		}
	}

?>
