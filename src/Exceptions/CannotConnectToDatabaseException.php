<?php

/**
 * Contains an exception class.
 *
 * @author Matthew Fritz <mattf@burbankpranormal.com>
 */

namespace Ghostly\Exceptions;

use Exception;

/**
 * This class represents an exception that is thrown when the Ghostly ORM cannot
 * connect to the configured database environment.
 *
 * The class is typically used to report the message from a PDOException but it
 * is explicitly used during connection failure.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */
class CannotConnectToDatabaseException extends Exception
{
	/**
	 * Constructs a new CannotConnectToDatabaseException object with an optional
	 * message.
	 *
	 * @param string $message Optional message to send with the exception
	 *
	 * @return CannotConnectToDatabaseException
	 */
	public function __construct($message="Cannot connect to database") {
		return parent::__construct($message);
	}
}