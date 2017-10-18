<?php
namespace Insphptor\Metrics;

use Insphptor\TestBase;
use Insphptor\Metrics\StarsMetric;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Storage\ClassesRepository;

class StarsMetricTest extends TestBase
{
    private $classes = [];
    private $repository;

    
    public function setUp()
    {
        $this->repository = ClassesRepository::instance();
    }
    

    private function up()
    {
        $this->classes[] = new AnalyzedClass(__DIR__.'/../pages/final.php');
        $this->classes[] = new AnalyzedClass(__DIR__.'/../pages/legacy.php');
        $this->classes[] = new AnalyzedClass(__DIR__.'/../pages/trait.php');

        foreach ($this->classes as $class) {
            $this->repository->pushClass($class);
        }
    }

    public function testGenerateCalculateProjectStarWithEmptyRepository()
    {
        $stars = StarsMetric::calculeProjectStars();

        $this->assertEquals(0, $stars);
    }

    public function testGenerateCalculateClassesStarWithEmptyRepository()
    {
        StarsMetric::calculeClassesStars();
        
        $classes = $this->repository->getClasses();

        $this->assertEquals(0, count($classes));
    }

    public function testGenerateAndCalculateAllClassesStar()
    {
        $this->up();
        StarsMetric::calculeClassesStars();

        $classes = $this->repository->getClasses();

        $this->assertTrue(count($classes) > 0);
        $this->assertTrue($classes[1]->star >= 0);
        $this->assertTrue($classes[1]->star <= 5);
    }

    public function testGenerateAndCalculateProjectStar()
    {
        $this->up();
        $stars = StarsMetric::calculeProjectStars();

        $this->assertTrue($stars >= 0);
        $this->assertTrue($stars <= 5);
    }

    public function tearDown()
    {
        $this->repository->clear();
    }
}
