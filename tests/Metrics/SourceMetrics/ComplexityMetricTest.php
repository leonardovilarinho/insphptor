<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Metrics\SourceMetrics\ComplexityMetric;

class ComplexityMetricTest extends TestBase
{
    public function testCalculateClassWithTwoComplexity()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/test1.php');
        $result = ComplexityMetric::value($class);
        $this->assertEquals(2, $result);
    }

    public function testCalculateClassWithAnyComplexity()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/interface.php');
        $result = ComplexityMetric::value($class);

        $this->assertEquals(1, $result);
    }
}
