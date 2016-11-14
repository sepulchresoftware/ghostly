<?php

/**
 * Contains the root of the Ghostly ORM.
 *
 * @author Matthew Fritz <mattf@burbankpranormal.com>
 */

namespace Ghostly\Core;

use Ghostly\Exceptions\CannotConnectToDatabaseException;

use PDO;
use PDOException;

/**
 * This class is the base from which the data models will extend.
 *
 * This class also handles the creation of the persistent database connection
 * as well as communication with the database server using PDO.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */
class Ghostly
{
	/**
	 * The database environment host.
	 *
	 * @var string
	 */
	private $host;

	/**
	 * The database environment port.
	 *
	 * @var int
	 */
	private $port;

	/**
	 * The database environment database name.
	 *
	 * @var string
	 */
	private $database;

	/**
	 * The database environment username.
	 *
	 * @var string
	 */
	private $user;

	/**
	 * The database environment password.
	 *
	 * @var string
	 */
	private $pass;

	/**
	 * The database environment flag for persistent connections.
	 *
	 * @var boolean
	 */
	private $persistent;

	/**
	 * The actual underlying PDO connection.
	 *
	 * @var PDO
	 */
	private $pdo;

	/**
	 * The query string that will be executed.
	 *
	 * @var string
	 */
	private $query_string;

	/**
	 * Constructs a new Ghostly object with the specified database connection parameters.
	 * If no parameters are specified explicitly, the configuration for the connection is
	 * read from values in the $_ENV superglobal.
	 *
	 * @param string $host The optional database server host name or IP
	 * @param int $port The optional port number for the database server
	 * @param string $database The optional name of the database to use
	 * @param string $user The optional username to provide for database server authentication
	 * @param string $pass The optional password to provide for database server authentication
	 * @param boolean $persistent The optional parameter for a persistent connection
	 *
	 * @return Ghostly
	 */
	public function __construct(
		$host="",
		$port="",
		$database="",
		$user=null,
		$pass=null,
		$persistent=true
	) {
		// do we have default configuration parameters or were values explicitly
		// specified?
		if(empty($host) &&
			empty($port) &&
			empty($database) &&
			empty($user) &&
			empty($pass)) {
			// read the configuration values from the $_ENV superglobal instead
			$this->host = $_ENV['DATABASE_HOST'];
			$this->port = $_ENV['DATABASE_PORT'];
			$this->database = $_ENV['DATABASE_NAME'];
			$this->user = $_ENV['DATABASE_USER'];
			$this->pass = $_ENV['DATABASE_PASS'];
		}
		else
		{
			$this->host = $host;
			$this->port = $port;
			$this->database = $database;
			$this->user = $user;
			$this->pass = $pass;
		}

		// should the database connection be persistent?
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