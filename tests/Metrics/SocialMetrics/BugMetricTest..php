<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Metrics\SocialMetrics\BugMetric;

class BugMetricTest extends TestBase
{
    public function testGenerateAndCalculateMetricSimple()
    {
        $class = new AnalyzedClass(__DIR__.'/../../pages/final.php');
        $result = BugMetric::value($class);

        $this->assertTrue(0 <= $result);
    }
}
