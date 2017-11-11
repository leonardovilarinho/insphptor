<?php

namespace Insphptor\Program\Config;

use Insphptor\Patterns\Singleton;
use Symfony\Component\Yaml\Yaml;

class Config extends Singleton
{
    /**
     * Array of global settings from console app, defined path, extensions and any
     * @var array
     */
    private static $config = [];

    /**
     * Initializable the color variable and get insphptor.yml project file, in end
     * optimize settings optionals.
     */
    protected function init()
    {
        $filename = getcwd() . '/insphptor.yml';

        if(!file_exists($filename) and !defined('IS_GLOBAL'))
            throw new \Exception('insphptor.yml not found!');

        if(file_exists($filename))
            self::$config = Yaml::parse(file_get_contents($filename));
        else
            self::$config = [];

        self::$config['project'] = getcwd();
        self::optimizeAllConfigurations();

        GitConfig::instance();
    }

    /**
     * Define optinional settings, transform in array and ass config array
     * @param  string $name name of settings
     */
    private function optimizeConfiguration(string $name, $default = false)
    {
        if (!isset(self::$config[$name])) {
            self::$config[$name] = $default !== false ? $default : [];
        }

        if (!is_array(self::$config[$name]) and $default === false) {
            self::$config[$name] = [ self::$config[$name] ];
        }
    }

    /**
     * Get array of settings
     * @return array application settings
     */
    public static function getConfig() : array
    {
        return self::$config;
    }

    /**
     * Optimize all configurations tags, puting in array or default value in all
     */
    private static function optimizeAllConfigurations()
    {
        self::optimizeConfiguration('level', 'NORMAL');
        self::optimizeConfiguration('rank', 5);
        self::optimizeConfiguration('git', 'auto');
        self::optimizeConfiguration('ignored');
        self::optimizeConfiguration('extensions');
        self::optimizeConfiguration('hide');
        self::optimizeConfiguration('views');
        self::optimizeConfiguration('only');
    }
}
