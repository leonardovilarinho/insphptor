<?php

namespace Insphptor\Storage;

use Insphptor\TestBase;
use Insphptor\Storage\SocialMetricsRepository;
use Insphptor\Metrics\IMetric;

class SocialMetricsRepositoryTest extends TestBase
{
    public function testNameClassesRepository()
    {
        $repository = new SocialMetricsRepository;
        foreach ($repository() as $name => $class) {
            $this->assertTrue(strlen($name) > 0);
        }
    }

    public function testInstanceClasses()
    {
        $repository = new SocialMetricsRepository;
        foreach ($repository() as $name => $class) {
            $this->assertTrue(new $class instanceof IMetric);
        }
    }
}
