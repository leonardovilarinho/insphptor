<?php
namespace Insphptor\Components;

use Insphptor\TestBaseComponent;
use Insphptor\Components\AttributesComponent;
use Insphptor\Analyzer\AnalyzedClass;

class AttributesComponentTest extends TestBaseComponent
{

   
    public function testAttributesWithEmptyTokenValue()
    {
        $attrs = AttributesComponent::find([]);
        $this->assertTrue(count($attrs) == 0);
        $this->assertEquals([], $attrs);
    }

    public function testAttributesWithLessAttrs()
    {
        $attrs = AttributesComponent::find($this->class->token);
        $this->assertTrue(count($attrs) == 0);
        $this->assertEquals([], $attrs);
    }

    public function testStaticAndPublicAttributeClass()
    {
        $attrs = $this->generateAttrs('final');
        $this->assertTrue(count($attrs) == 1);
        $this->assertEquals('public static', $attrs[1]['visibility']);
        $this->assertEquals('$staticValue', $attrs[1]['name']);
    }

    public function testPrivateAttributeClass()
    {
        $attrs = $this->generateAttrs('legacy');
        $this->assertTrue(count($attrs) == 3);
        $this->assertEquals('private', $attrs[1]['visibility']);
        $this->assertEquals('$name', $attrs[1]['name']);
    }

    public function testConstAttributeClass()
    {
        $attrs = $this->generateAttrs('legacy');
        $this->assertTrue(count($attrs) == 3);
        $this->assertEquals('const', $attrs[2]['visibility']);
        $this->assertEquals('APPNAME', $attrs[2]['name']);
    }

    public function testProtectedAttributeClass()
    {
        $attrs = $this->generateAttrs('legacy');
        $this->assertTrue(count($attrs) == 3);
        $this->assertEquals('protected', $attrs[3]['visibility']);
        $this->assertEquals('$file', $attrs[3]['name']);
    }

    
    private function generateAttrs(string $classname)
    {
        $class = new AnalyzedClass(__DIR__.'/../pages/'.$classname.'.php');
        return AttributesComponent::find($class->token);
    }
}
