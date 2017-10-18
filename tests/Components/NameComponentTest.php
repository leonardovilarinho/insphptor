<?php
namespace Insphptor\Components;

use Insphptor\TestBaseComponent;
use Insphptor\Components\NamespaceComponent;
use Insphptor\Analyzer\AnalyzedClass;

class NameComponentTest extends TestBaseComponent
{

    public function testNameWithLegacyAndAbstractClassValue()
    {
        $name = $this->generateName('legacy');
        $this->assertTrue(strlen($name) > 0);
        $this->assertEquals('MyBigClass', $name);
    }
    
    public function testNameWithEmptyTokenValue()
    {
        $namespace = NameComponent::find([]);
        $this->assertTrue(strlen($namespace) == 0);
        $this->assertEquals('', $namespace);
    }

    public function testGetNameValue()
    {
        $name = NameComponent::find($this->class->token);
        $this->assertTrue(strlen($name) > 0);
        $this->assertEquals('Base', $name);
    }

    public function testGetNameFromInterface()
    {
        $name = $this->generateName('interface');
        $this->assertTrue(strlen($name) > 0);
        $this->assertEquals('ILemon', $name);
    }

    public function testGetNameFromTrait()
    {
        $name = $this->generateName('trait');
        $this->assertTrue(strlen($name) > 0);
        $this->assertEquals('MyTrait', $name);
    }

    public function testGetNameFromFinalClass()
    {
        $name = $this->generateName('final');
        $this->assertTrue(strlen($name) > 0);
        $this->assertEquals('MyFinalClass', $name);
    }

    private function generateName(string $classname)
    {
        $class = new AnalyzedClass(__DIR__.'/../pages/'.$classname.'.php');
        return NameComponent::find($class->token);
    }
}
