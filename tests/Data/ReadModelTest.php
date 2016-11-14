<?php

namespace Ghostly\Tests;

use Ghostly\Data\ReadModel;
use Ghostly\Exceptions\ImmutableModelException;

use PHPUnit\Framework\TestCase;

class ReadModelTest extends TestCase
{
	protected static $readModel;

	public static function setUpBeforeClass() {
		// use default database configuration from $_ENV superglobal
        self::$readModel = new ReadModel();
    }

    public static function tearDownAfterClass() {
    	
    }

    /**
	 * @test
	 */
	public function database_connection_is_open() {
		$this->assertNotEmpty(self::$readModel);
	}

	/**
	 * @test
	 */
	public function setting_property_fails_in_read_model() {
		try {
			self::$readModel->bad_property = "Bad Value";

			// should not get here
			$this->fail("A read model should throw an exception when a __set() is performed");
		}
		catch(ImmutableModelException $e) {
			$this->assertTrue(true);
		}
	}
}