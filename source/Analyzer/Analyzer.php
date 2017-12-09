<?php
namespace Insphptor\Analyzer;

use Insphptor\Storage\ComponentsRepository;
use Insphptor\Storage\SourceMetricsRepository;
use Insphptor\Storage\SocialMetricsRepository;
use Insphptor\Patterns\Repository;

abstract class Analyzer
{
    private static $class;

    public static function calculateMetrics(AnalyzedClass &$class)
    {
        self::$class = $class;
        self::calculateMetric('source', new SourceMetricsRepository);

        if (HAS_GIT) {
            self::calculateMetric('social', new SocialMetricsRepository);
        }
    }

    /**
     * Find and generante all components from all classes this repository
     */
    public static function generateComponents(AnalyzedClass &$class)
    {
        $components = new ComponentsRepository;

        foreach ($components() as $name => $component) {
            $result = $component::find($class->token);
            $class->pushAttribute($name, $result);
        }
    }

    private static function calculateMetric(string $title, Repository $metrics)
    {
        foreach ($metrics() as $name => $metric) {
            $metric::value(self::$class);
        }
    }
}
