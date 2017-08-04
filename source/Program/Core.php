<?php

namespace Insphptor\Program;

use Insphptor\Patterns\Singleton;
use Symfony\Component\Yaml\Yaml;

class Core extends Singleton
{
    private static $color;
    public static $classes = [];
    private static $config;

    protected function init()
    {
        self::$color = new \Colors\Color;

        try {
            self::$config = Yaml::parse( file_get_contents( getcwd() . '/insphptor.yml' ) );
        }
        catch (\Exception $e) {
            self::$config = Yaml::parse( file_get_contents( __DIR__ . '/../../insphptor.yml' ) );
        }
    }

    public static function config()
    {
        return self::$config;
    }

    public static function color($msg)
    {
        $c = self::$color;
        return $c($msg);
    }
}