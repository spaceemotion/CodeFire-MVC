<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Text helper
	 *
	 * @package helper
	 * @version 1.0
	 */


	function censor_text($text, $censored, $replace) {
		$return_str = $text;

		foreach($censored as $bad)
			$return_str = str_replace ($bad, $replace, $return_str);

		return $return_str;
	}

	function limit_characters($text, $max = 64) {
		$return_str = $text;

		if(strlen($text) > $max)
			$return_str = substr($text, 0, $max)."...";

		return $return_str;
	}

	
?>
