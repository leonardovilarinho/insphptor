<?php

namespace Insphptor;

use PHPUnit\Framework\TestCase;
use Insphptor\Program\Config\Config;

class TestBase extends TestCase
{
    protected function setUp()
    {
        require __DIR__.'/../source/globals.php';
        Config::instance();
    }
}
