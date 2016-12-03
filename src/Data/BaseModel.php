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
	 * Array containing the inaccessible/dynamic properties of the data models.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Constructs a new BaseModel instance.
	 *
	 * @return BaseModel
	 */
	public function __construct() {
		$this->ghostly = Ghostly::fromConnectionDefaults();
		$this->data = [];
	}

	/**
	 * Retrieves dynamic attributes based on data received. Returns null if the
	 * appropriate attribute cannot be resolved.
	 *
	 * @param string $key The name of the attribute to retrieve
	 * @return string|int|null
	 */
	public function __get($key) {
		if(array_key_exists($key, $this->data)) {
			return $this->data[$key];
		}

		return null;
	}
}