<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Metrics\SourceMetrics\CohesionMetric;

class CohesionMetricTest extends TestBase
{
    public function testGenerateAndCalculateComplingWithOne()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/trait.php');
        $result = CohesionMetric::value($class);
        $this->assertEquals(2, $result);
    }

    public function testGenerateAndCalculateComplingWithZero()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/interface.php');
        $result = CohesionMetric::value($class);

        $this->assertEquals(1, $result);
    }
}
