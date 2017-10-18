<?php

namespace Insphptor\Analyzer;

use Insphptor\TestBaseComponent;
use Insphptor\Analyzer\AnalyzedClass;

class AnalyzedClassTest extends TestBaseComponent
{
    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage FileNotFound.php not found
     */
    public function testInitWithInvalidFileClass()
    {
        new AnalyzedClass('FileNotFound.php');
    }

    public function testGetValidParamClass()
    {
        $this->assertEquals($this->filename, $this->class->filename);
    }

    public function testGetInvalidParamClass()
    {
        $this->assertNull($this->class->blabla);
    }

    public function testPushAnParamClass()
    {
        $this->class->pushAttribute('test', 6);
        $this->assertEquals($this->class->test, 6);
        $this->assertArrayHasKey('test', $this->class->getAttributes());
    }

    public function testGetAllParamsClass()
    {
        $this->assertTrue(is_array($this->class->getAttributes()));
    }

    public function testPushAnMetricClass()
    {
        $this->class->pushMetric('myMetric', 12);
        $this->assertEquals($this->class->metrics['myMetric'], 12);
        $this->assertArrayHasKey('myMetric', $this->class->metrics);
    }

    public function testToStringGetFilenameClass()
    {
        $this->assertEquals($this->filename, (string)$this->class);
    }

    public function testHasTokenizeClass()
    {
        $this->assertTrue(is_array($this->class->token));
    }

    public function testToArrayLessMethodsClass()
    {
        $this->assertTrue(is_array($this->class->toArray()));
        $this->assertArrayHasKey('filename', $this->class->toArray());
        $this->assertFalse(array_key_exists('token', $this->class->toArray()));
    }

    public function testToArrayWithMethodsClass()
    {
        $this->class->pushAttribute('methods', ['myMethod1', 'myMethod2']);
        $this->assertArrayHasKey('methods', $this->class->toArray());
    }

    public function testToArrayWithMethodsAndWithContentClass()
    {
        $this->class->pushAttribute('methods', ['content' => 'blabla']);
        $this->assertArrayHasKey('methods', $this->class->toArray());
    }
}
