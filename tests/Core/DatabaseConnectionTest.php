<?php

namespace Ghostly\Tests;

use Ghostly\Core\Ghostly;
use Ghostly\Exceptions\CannotConnectToDatabaseException;

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
	public static function setUpBeforeClass() {
        
    }

    public static function tearDownAfterClass() {

    }

    /**
	 * @test
	 */
	public function database_connection_is_open() {
		// use default database configuration from $_ENV superglobal
		$orm = Ghostly::fromConnectionDefaults();
		$this->assertNotEmpty($orm);
		$orm->close();
	}

	/**
	 * @test
	 */
	public function invalid_database_connection_throws_exception() {
		try {
			$bad = Ghostly::fromConnection(
				$_ENV['DATABASE_HOST'],
				$_ENV['DATABASE_PORT'],
				'ghostly-database-does-not-exist',
				$_ENV['DATABASE_USER'],
				$_ENV['DATABASE_PASS'],
				false
			);

			// should not get here
			$this->fail('Invalid Ghostly connection did not result in an exception');
		}
		catch(CannotConnectToDatabaseException $e) {
			// the database connection could not be made so we're good
			$this->assertTrue(true);
		}
	}
}