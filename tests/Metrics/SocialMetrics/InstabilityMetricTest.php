<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Metrics\SocialMetrics\InstabilityMetric;

class InstabilityMetricTest extends TestBase
{
    public function testGenerateAndCalculateMetricSimple()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/final.php');
        $result = InstabilityMetric::value($class);

        $this->assertTrue(0 <= $result);
    }
}
