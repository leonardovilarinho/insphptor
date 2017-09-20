<?php

namespace Insphptor\Program;

use Insphptor\Patterns\Singleton;
use Symfony\Component\Yaml\Yaml;
use Colors\Color;

class Core extends Singleton
{
    private static $color;
    private static $config;

    protected function init()
    {
        self::$color = new Color;

        try {
            self::$config = Yaml::parse(file_get_contents(getcwd() . '/insphptor.yml'));
        } catch (\Exception $e) {
            self::$config = Yaml::parse(file_get_contents(__DIR__ . '/../../insphptor.yml'));
        }

        $this->optimizeConfiguration('ignored');
        $this->optimizeConfiguration('extensions');
        $this->optimizeConfiguration('hide');
        $this->optimizeConfiguration('views');

        self::$config['project'] = getcwd();
    }

    private function optimizeConfiguration($name)
    {
        if (!isset(self::$config[$name])) {
            self::$config[$name] = [];
        }

        if (!is_array(self::$config[$name])) {
            self::$config[$name] = [ self::$config[$name] ];
        }
    }

    public static function config() : array
    {
        return self::$config;
    }

    public static function color($msg) : Color
    {
        $c = self::$color;
        return $c($msg);
    }
}
