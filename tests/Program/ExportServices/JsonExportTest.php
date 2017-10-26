<?php

namespace Insphptor\Program;

use Insphptor\TestBase;
use Insphptor\Program\ExportServices\JsonExport;
use Insphptor\Storage\ClassesRepository;
use Insphptor\Analyzer\AnalyzedClass;
use Symfony\Component\Console\Output\ConsoleOutput;

class JsonExportTest extends TestBase
{
    
    public function setUp()
    {
        mkdir(__DIR__.'/../../export/');
    }
    
    public function testExportEmptyClasses()
    {
        $output = new ConsoleOutput();
        $json = new JsonExport(ClassesRepository::instance(), [], $output);
        $json->export(__DIR__.'/../../export/', 5, 'flag test');

        $this->assertTrue(file_exists(__DIR__.'/../../export/info.json'));
    }

    public function testExportWithClasses()
    {
        $repo = ClassesRepository::instance();
        $repo->pushClass(new AnalyzedClass(__DIR__.'/../../pages/test1.php'));
        $repo->pushClass(new AnalyzedClass(__DIR__.'/../../pages/interface.php'));

        $output = new ConsoleOutput();
        $json = new JsonExport($repo, [], $output);
        $json->export(__DIR__.'/../../export/', 4, 'flag test2');
        $repo->clear();

        $this->assertTrue(file_exists(__DIR__.'/../../export/info.json'));
    }

    
    public function tearDown()
    {
        array_map('unlink', glob(__DIR__.'/../../export/*.*'));
        rmdir(__DIR__.'/../../export/');
    }
}
