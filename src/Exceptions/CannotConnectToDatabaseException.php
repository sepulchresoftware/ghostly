<?php

/**
 * This class represents an exception that is thrown when the Ghostly ORM cannot
 * connect to the configured database environment.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */

namespace Ghostly\Exceptions;

use Exception;

class CannotConnectToDatabaseException extends Exception
{
	/**
	 * Constructs a new CannotConnectToDatabaseException object with an optional
	 * message.
	 *
	 * @param string $message Optional message to send with the exception
	 */
	public function __construct($message="Cannot connect to database") {
		return parent::__construct($message);
	}
}