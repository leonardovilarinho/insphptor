<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Metrics\SourceMetrics\AfferentMetric;

class AfferentMetricTest extends TestBase
{
    public function testOne()
    {
        $this->assertTrue(true);
    }
    // public function testGenerateAndCalculateComplingWithOne() {
    //     $class = new AnalyzedClass(__DIR__.'/../../pages/trait.php');
    //     $result = AfferentMetric::value($class);

    //     $this->assertEquals(1, $result);
    // }

    // public function testGenerateAndCalculateComplingWithZero() {
    //     $class = new AnalyzedClass(__DIR__.'/../../pages/legacy.php');
    //     $result = AfferentMetric::value($class);

    //     $this->assertEquals(0, $result);
    // }
}
