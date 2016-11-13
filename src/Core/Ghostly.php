<?php

/**
 * This class is the base from which the data models will extend. This class also
 * handles the creation of the persistent database connection as well as communication
 * with the database server using PDO.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */

namespace Ghostly\Core;

use Ghostly\Exceptions\CannotConnectToDatabaseException;

use \PDO;
use \PDOException;

class Ghostly
{
	private $host;
	private $port;
	private $database;
	private $user;
	private $pass;
	private $persistent;

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
	 * @param string $user The optional username to provide for database server authentication
	 * @param string $pass The optional password to provide for database server authentication
	 * @param boolean $persistent The optional parameter for a persistent connection
	 */
	public function __construct(
		$host,
		$port,
		$database,
		$user=null,
		$pass=null,
		$persistent=true
	) {
		$this->host = $host;
		$this->port = $port;
		$this->database = $database;
		$this->user = $user;
		$this->pass = $pass;
		$this->persistent = $persistent;

		// try to create a database connection
		try {
			$options = [PDO::FETCH_OBJ => true];
			if($this->persistent) {
				$options[PDO::ATTR_PERSISTENT] = true;
			}

			$this->pdo = new PDO(
				$this->makeConnectionString(),
				$this->user,
				$this->pass,
				$options
			);
		}
		catch(PDOException $e) {
			throw new CannotConnectToDatabaseException($e->getMessage());
		}
	}

	/**
	 * Closes the open database connection. If a connection is not open this method
	 * does nothing.
	 */
	public function close() {
		if(!empty($this->pdo)) {
			$this->pdo = null;
		}
	}

	/**
	 * Creates and returns the DSN string for a MySQL connection. The values are
	 * read from the values provided when this class is instantiated.
	 *
	 * @return string
	 */
	private function makeConnectionString() {
		return "mysql:host={$this->host};port={$this->port};dbname={$this->database}";
	}
}