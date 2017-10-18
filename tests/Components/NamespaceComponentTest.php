<?php
namespace Insphptor\Components;

use Insphptor\TestBaseComponent;
use Insphptor\Components\NamespaceComponent;
use Insphptor\Analyzer\AnalyzedClass;

class NamespaceComponentTest extends TestBaseComponent
{

    public function testNamespaceWithLegacyClassValue()
    {
        $class = new AnalyzedClass(__DIR__.'/../pages/legacy.php');
        $namespace = NamespaceComponent::find($class->token);
        $this->assertTrue(strlen($namespace) == 0);
        $this->assertEquals($namespace, '');
    }
    
    public function testNamespaceWithEmptyTokenValue()
    {
        $namespace = NamespaceComponent::find([]);
        $this->assertTrue(strlen($namespace) == 0);
        $this->assertEquals('', $namespace);
    }

    public function testGetNamespaceValue()
    {
        $namespace = NamespaceComponent::find($this->class->token);
        $this->assertTrue(strlen($namespace) > 0);
        $this->assertEquals('Foo\Bar', $namespace);
    }
}
