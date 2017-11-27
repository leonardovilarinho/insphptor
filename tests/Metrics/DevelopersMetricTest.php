<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Metrics\DevelopersMetric;
use Symfony\Component\Console\Output\ConsoleOutput;

class DevelopersMetricTest extends TestBase
{
    public function testGenerateAndCalculateDevs()
    {
        $output = new ConsoleOutput;

        $result = DevelopersMetric::generate($output);

        $this->assertEquals(DevelopersMetric::getDevelopers(), $result);
    }

    public function testGenerateWithAlreadyDevs()
    {
        $output = new ConsoleOutput;

        $result = DevelopersMetric::generate($output);

        $this->assertEquals(DevelopersMetric::getDevelopers(), $result);
    }
}
