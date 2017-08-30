<?php

namespace Insphptor\Helpers;

use Syntax\Php;

abstract class SyntaxCheckerHelper implements Helper
{
    private static $instance = null;

    public static function run(array $args) : bool
    {
        if (self::$instance == null) {
            self::$instance = new Php();
        }
        $result = self::$instance->check($args[0]);

        return $result['validity'];
    }
}
