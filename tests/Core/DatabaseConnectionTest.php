<?php

namespace Ghostly\Tests;

use Ghostly\Core\Ghostly;

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
	protected $orm;

	public static function setUpBeforeClass() {
        $this->$orm = new Ghostly(
			'localhost',
			'3306',
			'ghostly-tests',
			'root',
			'root'
		);
    }

    public static function tearDownAfterClass() {
        $this->orm->close();
    }

    /**
	 * @test
	 */
	public function database_connection_is_open() {
		$this->assertNotEmpty($orm);
	}
}