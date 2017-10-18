<?php
namespace Insphptor\Helpers;

use Insphptor\TestBase;

class GitTraitTest extends TestBase
{
    public function testTraitWithoutParams()
    {
        $mock = $this->getMockForTrait(\Insphptor\Helpers\GitTrait::class);
        $this->assertTrue(count($mock->git('log')) > 0);
    }

    public function testTraitWithParams()
    {
        $mock = $this->getMockForTrait(\Insphptor\Helpers\GitTrait::class);
        $this->assertEquals(0, count($mock->git('', ['-v'])));
    }
}
