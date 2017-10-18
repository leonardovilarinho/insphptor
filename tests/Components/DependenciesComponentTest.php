<?php
namespace Insphptor\Components;

use Insphptor\TestBaseComponent;
use Insphptor\Components\DependenciesComponent;
use Insphptor\Analyzer\AnalyzedClass;

class DependenciesComponentTest extends TestBaseComponent
{

   
    public function testDependenciesWithEmptyTokenValue()
    {
        $dependencies = DependenciesComponent::find([]);
        $this->assertTrue(count($dependencies) == 0);
        $this->assertEquals([], $dependencies);
    }

    public function testDependenciesFromUseAndNewWords()
    {
        $dependencies = $this->generateDependencies('final');
        $this->assertEquals(2, count($dependencies));
    }

    public function testDependenciesFromOnlyUseWords()
    {
        $dependencies = $this->generateDependencies('interface');
        $this->assertEquals(2, count($dependencies));
    }

    public function testDependenciesFromOnlyNewWords()
    {
        $dependencies = $this->generateDependencies('trait');
        $this->assertEquals(1, count($dependencies));
    }

    public function testDependenciesFromLessWords()
    {
        $dependencies = DependenciesComponent::find($this->class->token);
        $this->assertEquals(0, count($dependencies));
    }

    private function generateDependencies(string $classname)
    {
        $class = new AnalyzedClass(__DIR__.'/../pages/'.$classname.'.php');
        return DependenciesComponent::find($class->token);
    }
}
