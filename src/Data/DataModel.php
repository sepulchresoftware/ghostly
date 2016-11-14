<?php

/**
 * Contains the read/write data representation for Ghostly ORM.
 *
 * @author Matthew Fritz <mattf@burbankpranormal.com>
 */

namespace Ghostly\Data;

use Ghostly\Data\BaseModel;

/**
 * This class is the read/write data representation. This should be used as the
 * parent class for all read/write data operations.
 *
 * This class subclasses from DataModel.
 *
 * @author Matthew Fritz <mattf@burbankparanormal.com>
 */
class DataModel extends BaseModel
{
	/**
	 * Constructs a new DataModel instance.
	 *
	 * @return DataModel
	 */
	public function __construct() {
		parent::__construct();
	}
}