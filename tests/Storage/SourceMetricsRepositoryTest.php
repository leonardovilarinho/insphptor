<?php

namespace Insphptor\Storage;

use Insphptor\TestBase;
use Insphptor\Storage\SourceMetricsRepository;
use Insphptor\Metrics\IMetric;

class SourceMetricsRepositoryTest extends TestBase
{
    public function testNameClassesRepository()
    {
        $repository = new SourceMetricsRepository;
        foreach ($repository() as $name => $class) {
            $this->assertTrue(strlen($name) > 0);
        }
    }

    public function testInstanceClasses()
    {
        $repository = new SourceMetricsRepository;
        foreach ($repository() as $name => $class) {
            $this->assertTrue(new $class instanceof IMetric);
        }
    }
}
