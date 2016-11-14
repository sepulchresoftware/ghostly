<?php

/**
 * Contains an exception class.
 *
 * @author Matthew Fritz <mattf@burbankpranormal.com>
 */

namespace Ghostly\Exceptions;

use Exception;

/**
 * This class represents an exception that is thrown when a read-only model in
 * the Ghostly ORM attempts to perform write operations.
 *
 * This exception will typically only be thrown from the ReadModel class.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */
class ImmutableModelException extends Exception
{
	/**
	 * Constructs a new ImmutableModelException object with an optional message.
	 *
	 * @param string $message Optional message to send with the exception
	 *
	 * @return ImmutableModelException
	 */
	public function __construct($message="Cannot write in a read model") {
		return parent::__construct($message);
	}
}