<?php

namespace Insphptor;

use PHPUnit\Framework\TestCase;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Program\Config\Settings;

class TestBaseComponent extends TestCase
{
    protected $class;
    protected $filename;
    
    protected function setUp()
    {
        require __DIR__.'/../source/globals.php';
        Settings::instance();
        $this->filename = __DIR__.'/pages/test1.php';
        $this->class = new AnalyzedClass($this->filename);
    }
}
