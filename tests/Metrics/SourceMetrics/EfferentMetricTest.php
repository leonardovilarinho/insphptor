<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Metrics\SourceMetrics\EfferentMetric;

class EfferentMetricTest extends TestBase
{
    public function testCalculateClassWithZeroDependencies()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/test1.php');
        $result = EfferentMetric::value($class);
        $this->assertEquals(0, $result);
    }

    public function testCalculateClassWithTwoDependencies()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/interface.php');
        $result = EfferentMetric::value($class);

        $this->assertEquals(2, $result);
    }
}
