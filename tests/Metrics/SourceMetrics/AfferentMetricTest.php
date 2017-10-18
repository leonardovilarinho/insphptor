<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Metrics\SourceMetrics\AfferentMetric;
use Insphptor\Storage\ClassesRepository;

class AfferentMetricTest extends TestBase
{
    private $repository;

    public function setUp()
    {
        $this->repository = ClassesRepository::instance();
        $this->repository->pushClass(new AnalyzedClass(__DIR__.'/../../pages/trait.php'));
        $this->repository->pushClass(new AnalyzedClass(__DIR__.'/../../pages/legacy.php'));
        $this->repository->pushClass(new AnalyzedClass(__DIR__.'/../../pages/interface.php'));
    }
    
    public function testGenerateAndCalculateComplingWithOne()
    {
        $result = AfferentMetric::value($this->repository->getClasses()[0]);

        $this->assertEquals(1, $result);
    }

    public function testGenerateAndCalculateComplingWithZero()
    {
        $class = new AnalyzedClass($this->repository->getClasses()[1]);
        $result = AfferentMetric::value($class);

        $this->assertEquals(0, $result);
    }

    
    public function tearDown()
    {
        $this->repository->clear();
    }
}
