<?php
namespace Insphptor\Components;

use Insphptor\TestBaseComponent;
use Insphptor\Components\TypeComponent;
use Insphptor\Analyzer\AnalyzedClass;

class TypeComponentTest extends TestBaseComponent
{
    public function testGetTypeWithEmptyToken()
    {
        $type = TypeComponent::find([]);
        $this->assertTrue(strlen($type) == 4);
        $this->assertEquals('file', $type);
    }
    
    public function testGetTypeWithClass()
    {
        $type = TypeComponent::find($this->class->token);
        $this->assertTrue(strlen($type) > 0);
        $this->assertEquals('class', $type);
    }

    public function testGetTypeWithAbstractAndLegacyClass()
    {
        $type = $this->generateType('legacy');
        $this->assertTrue(strlen($type) > 0);
        $this->assertEquals('abstract class', $type);
    }

    public function testGetTypeWithFinalClass()
    {
        $type = $this->generateType('final');
        $this->assertTrue(strlen($type) > 0);
        $this->assertEquals('final class', $type);
    }

    public function testGetTypeWithTrait()
    {
        $type = $this->generateType('trait');
        $this->assertTrue(strlen($type) > 0);
        $this->assertEquals('trait', $type);
    }

    public function testGetTypeWithInterface()
    {
        $type = $this->generateType('interface');
        $this->assertTrue(strlen($type) > 0);
        $this->assertEquals('interface', $type);
    }

    private function generateType(string $classname)
    {
        $class = new AnalyzedClass(__DIR__.'/../pages/'.$classname.'.php');
        return TypeComponent::find($class->token);
    }
}
