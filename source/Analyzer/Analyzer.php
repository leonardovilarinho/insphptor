<?php
namespace Insphptor\Analyzer;

use Insphptor\Storage\ClassesRepository;
use Insphptor\Storage\ComponentsRepository;
use Insphptor\Storage\SourceMetricsRepository;
use Insphptor\Storage\SocialMetricsRepository;
use Insphptor\Patterns\Repository;

abstract class Analyzer
{
    private static $class;
    private static $repository;

    public static function analyze(AnalyzedClass &$class)
    {
        self::$class = $class;
        self::$repository = ClassesRepository::instance();

        self::generateComponents();

        self::calculateMetric('source', new SourceMetricsRepository);

        if (HAS_GIT) {
            self::calculateMetric('social', new SocialMetricsRepository);
        }
    }

    /**
     * Find and generante all components from all classes this repository
     */
    private static function generateComponents()
    {
        $components = new ComponentsRepository;
 
        foreach ($components() as $name => $component) {
            $result = $component::find(self::$class->token);
            self::$class->pushAttribute($name, $result);
        }

        if (in_array(self::$class->type, config()['hide'])) {
            self::$repository->removeClass(self::$class);
        }
    }

    private static function calculateMetric(string $title, Repository $metrics)
    {
        foreach ($metrics() as $name => $metric) {
            $metric::value(self::$class);
        }
    }
}
