<?php

namespace Ghostly\Tests;

use Ghostly\Data\DataModel;
use Ghostly\Exceptions\CannotConnectToDatabaseException;

use PHPUnit\Framework\TestCase;

class DataModelTest extends TestCase
{
	protected static $dataModel;

	public static function setUpBeforeClass() {
		// use default database configuration from $_ENV superglobal
        self::$dataModel = new DataModel();
    }

    public static function tearDownAfterClass() {
    	
    }

    /**
	 * @test
	 */
	public function database_connection_is_open() {
		$this->assertNotEmpty(self::$dataModel);
	}
}