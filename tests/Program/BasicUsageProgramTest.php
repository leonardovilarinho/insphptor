<?php

namespace VertuPhp\Tests\Program;

use VertuPhp\Tests\TestBase;
use VertuPhp\Example;

class BasicUsageProgramTest extends TestBase
{
	public function testMyFirstTest()
	{
		$this->assertEquals(Example::calculate(), 4);
	}

	public function testMyTwoTest()
	{
		$this->assertEquals(Example::calculateTwo(), 2);
	}
}