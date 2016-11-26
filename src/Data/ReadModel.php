<?php

/**
 * Contains the read-only data representation for Ghostly ORM.
 *
 * @author Matthew Fritz <mattf@burbankpranormal.com>
 */

namespace Ghostly\Data;

use Ghostly\Data\BaseModel;
use Ghostly\Exceptions\ImmutableModelException;

/**
 * This class is the read-only data representation. This should be used as the
 * parent class for all read-only data operations.
 *
 * Attempting to perform write operations with this class will throw instances
 * of ImmutableModelException.
 *
 * This class subclasses from BaseModel.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */
class ReadModel extends BaseModel
{
	/**
	 * Constructs a new ReadModel instance.
	 *
	 * @return ReadModel
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Magic method overridden to prevent mutability.
	 *
	 * @param string $name The name of the variable to set
	 * @param mixed $value The value of the variable to set
	 *
	 * @throws ImmutableModelException
	 *
	 * @return void
	 */
	public function __set($name, $value) {
		throw new ImmutableModelException(
			"The property named '$name' cannot be assigned a value in a read model"
		);
	}
}