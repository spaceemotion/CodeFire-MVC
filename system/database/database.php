<?php if ( !defined('BASE_DIR') ) exit('No direct script access allowed');

	/**
	 * Database class
	 *
	 * @package database
	 * @version 1.0
	 */
	class CF_Database extends PDO {
		public function __construct($type, $host, $user, $passwd, $db, $port = null) {
			$dsn = false;

			switch (strtolower($type)) {
				case 'mysql':
					$dsn = "mysql:dbname=$db;host=$host";

					break;

				default:
					throw new Exception("No valid driver support found!");
			}

			if($port) $dsn .= ";port=$port";

			parent::__construct($dsn, $user, $passwd);
		}
	}

?>
