<?php

namespace Insphptor\Program;

use Insphptor\Patterns\Singleton;
use Symfony\Component\Yaml\Yaml;
use Colors\Color;

class Core extends Singleton
{
    /**
     * Store instance for Color extension, to print persons messages
     * @var Colors\Color
     */
    private static $color;

    /**
     * Array of global settings from console app, defined path, extensions and any
     * @var array
     */
    private static $config;

    /**
     * Initializable the color variable and get insphptor.yml project file, in end
     * optimize settings optionals.
     * @return [type] [description]
     */
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

    /**
     * Define optinional settings, transform in array and ass config array
     * @param  string $name name of settings
     */
    private function optimizeConfiguration(string $name)
    {
        if (!isset(self::$config[$name])) {
            self::$config[$name] = [];
        }

        if (!is_array(self::$config[$name])) {
            self::$config[$name] = [ self::$config[$name] ];
        }
    }

    /**
     * Get array of settings
     * @return array application settings
     */
    public static function config() : array
    {
        return self::$config;
    }

    /**
     * Alias to use color extension
     * @param  string $msg message to print in output
     * @return Colors\Color      instance of extension color with message
     */
    public static function color(string $msg) : Color
    {
        $c = self::$color;
        return $c($msg);
    }
}
