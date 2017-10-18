<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Metrics\SourceMetrics\SizeMetric;

class SizeMetricTest extends TestBase
{
    public function testCalculateClassWithManySize()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/legacy.php');
        $result = SizeMetric::value($class);
        $this->assertTrue(10 < $result);
        $this->assertTrue(15 > $result);
    }

    public function testCalculateClassWithZeroSize()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/interface.php');
        $result = SizeMetric::value($class);

        $this->assertTrue(8 <= $result);
        $this->assertTrue(12 > $result);
    }
}
