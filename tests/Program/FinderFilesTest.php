<?php

namespace Insphptor\Program;

use Insphptor\TestBase;
use Insphptor\Program\FinderFiles;

class FinderFilesTest extends TestBase
{
    public function testInsphptorFinderFilesRun()
    {
        $finder = (new FinderFiles())->getFiles();
        
        $this->assertTrue(count($finder) > 10);
        $this->assertTrue(count($finder) < 100);

        
        foreach ($finder as $file) {
            $isPHP = stripos($file->getRealPath(), '.php') !== false;
            $this->assertTrue($isPHP);
        }
    }
}
