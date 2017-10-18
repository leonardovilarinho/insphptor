<?php

namespace Insphptor\Storage;

use Insphptor\TestBase;
use Insphptor\Storage\ClassesRepository;
use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class ClassesRepositoryTest extends TestBase
{
    public function testInitEmptyRepository()
    {
        $repository = ClassesRepository::instance();
        $this->assertEquals(0, count($repository->getClasses()));
    }

    public function testAddAnClassInRepository()
    {
        $class = new AnalyzedClass(__DIR__.'/../pages/test1.php');
        $repository = ClassesRepository::instance();
        $repository->pushClass($class);
        $this->assertEquals(1, $repository->count());
    }

    public function testRemoveAnClassInRepository()
    {
        $class = new AnalyzedClass(__DIR__.'/../pages/test1.php');
        $repository = ClassesRepository::instance();
        $repository->removeClass($class);
        $this->assertEquals(0, $repository->count());
    }
}
