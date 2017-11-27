<?php
namespace Insphptor\Components;

use Insphptor\TestBaseComponent;
use Insphptor\Components\MethodsComponent;
use Insphptor\Analyzer\AnalyzedClass;

class MethodsComponentTest extends TestBaseComponent
{

   
    public function testMethodsWithEmptyTokenValue()
    {
        $methods = MethodsComponent::find([]);
        $this->assertTrue(count($methods) == 0);
        $this->assertEquals([], $methods);
    }

    public function testMethodsPublicScope()
    {
        $methods = MethodsComponent::find($this->class->token);
        $this->assertTrue(count($methods) == 1);
        $this->assertEquals('get', $methods[1]['name']);
        $this->assertEquals('public', $methods[1]['visibility']);
    }

    public function testTwoMethodsProtectedAndStaticScope()
    {
        $methods = $this->generateMethods('final');
        $this->assertTrue(count($methods) == 2);
        $this->assertEquals('myMethod', $methods[1]['name']);
        $this->assertEquals('protected', $methods[1]['visibility']);
    }

    public function testTwoMethodsProtectedAndAbstractScope()
    {
        $methods = $this->generateMethods('trait');
        $this->assertTrue(count($methods) == 2);
        $this->assertEquals('myAbs', $methods[2]['name']);
        $this->assertEquals('protected', $methods[2]['visibility']);
    }
    
    private function generateMethods(string $classname)
    {
        $class = new AnalyzedClass(__DIR__.'/../pages/'.$classname.'.php');
        return MethodsComponent::find($class->token);
    }
}
