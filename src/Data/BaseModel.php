<?php

/**
 * Contains the base data representation for Ghostly ORM.
 *
 * @author Matthew Fritz <mattf@burbankpranormal.com>
 */

namespace Ghostly\Data;

use Ghostly\Core\Ghostly;

/**
 * This class is the base data representation. This should be used as the parent
 * class for all models so they can share functionality.
 *
 * This class includes an instance of the core Ghostly class.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */
class BaseModel
{
	/**
	 * An instance of the Ghostly ORM for database operations.
	 *
	 * @var Ghostly
	 */
	protected $ghostly;

	/**
	 * Constructs a new BaseModel instance.
	 *
	 * @return BaseModel
	 */
	public function __construct() {
		$this->ghostly = Ghostly::fromConnectionDefaults();
	}
}