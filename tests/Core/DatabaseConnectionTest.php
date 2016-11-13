<?php

namespace Ghostly\Tests;

use Ghostly\Core\Ghostly;

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
	public function testDatabaseConnectionWorks() {
		$orm = new Ghostly(
			'localhost',
			'3306',
			'ghostly-tests',
			'root',
			'root'
		);

		$this->assertNotEmpty($orm);
	}
}