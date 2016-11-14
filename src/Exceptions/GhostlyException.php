<?php

/**
 * Contains an exception class.
 *
 * @author Matthew Fritz <mattf@burbankpranormal.com>
 */

namespace Ghostly\Exceptions;

use Exception;

/**
 * This class represents a base exception that should be the parent class of all
 * other exceptions within the Ghostly ORM.
 *
 * Developers can catch this exception if they are not concerned with what kind
 * of exception is thrown, but rather just that an exception was thrown.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */
class GhostlyException extends Exception
{
	/**
	 * Constructs a new GhostlyException object with a message.
	 *
	 * @param string $message Message to send with the exception
	 *
	 * @return GhostlyException
	 */
	public function __construct($message) {
		return parent::__construct($message);
	}
}