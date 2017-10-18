<?php

namespace Insphptor\Storage;

use Insphptor\TestBase;
use Insphptor\Storage\ComponentsRepository;
use Insphptor\Components\IComponent;

class ComponentsRepositoryTest extends TestBase
{
    public function testNameComponentsRepository()
    {
        $repository = new ComponentsRepository;
        foreach ($repository() as $name => $component) {
            $this->assertTrue(strlen($name) > 0);
        }
    }

    public function testCountLengthRepository()
    {
        $repository = new ComponentsRepository;
        $this->assertTrue($repository->count() > 0);
    }

    public function testInstanceClasses()
    {
        $repository = new ComponentsRepository;
        foreach ($repository() as $name => $component) {
            $this->assertTrue(new $component instanceof IComponent);
        }
    }
}
