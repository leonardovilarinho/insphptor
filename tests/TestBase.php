<?php

namespace Insphptor;

use PHPUnit\Framework\TestCase;
use Insphptor\Program\Config\Settings;

class TestBase extends TestCase
{
    protected function setUp()
    {
        require __DIR__.'/../source/globals.php';
        Settings::instance();
    }
}
