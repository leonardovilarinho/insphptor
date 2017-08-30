<?php

namespace Insphptor\TestBase;

use Insphptor\TestBase;

class BasicUsageProgramTest extends TestBase
{
	public function testMyFirstTest()
	{
		$this->assertEquals(2 + 2, 4);
	}

}