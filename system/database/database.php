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
					show_error("No valid driver support found (requested type: '$type')!");
			}

			if($port) $dsn .= ";port=$port";

			try {
				parent::__construct($dsn, $user, $passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

			} catch(PDOException $e) {
				show_error("Unable to connect to database! Please check your configuration.");
			}
		}
	}


?>
