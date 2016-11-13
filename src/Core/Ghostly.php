<?php

/**
 * This class is the base from which the data models will extend. This class also
 * handles the creation of the persistent database connection as well as communication
 * with the database server using PDO.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */

namespace Ghostly\Core;

use PDOException;

class Ghostly
{
	private $host;
	private $port;
	private $database;
	private $user;
	private $pass;

	// the actual database connection through PDO
	private $pdo;

	// the query string that will be executed
	private $query_string;

	/**
	 * Constructs a new Ghostly object with the specified database connection parameters.
	 *
	 * @param string $host The database server host name or IP
	 * @param int $port The port number for the database server
	 * @param string $database The name of the database to use
	 * @param string $user The username to provide for database server authentication
	 * @param string $pass The password to provide for database server authentication
	 */
	public function __construct(
		$host,
		$port,
		$database,
		$user,
		$pass
	) {
		$this->host = $host;
		$this->port = $port;
		$this->database = $database;
		$this->user = $user;
		$this->pass = $pass;
	}
}