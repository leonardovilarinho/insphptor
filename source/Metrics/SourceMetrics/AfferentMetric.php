<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Storage\ClassesRepository;

class AfferentMetric implements IMetric
{

    private static $weight = 1;

    /**
     * Calcule afferent from an class
     * @param  AnalyzedClass &$class target class from calculate
     * @return float                afferent
     */
    public static function value(AnalyzedClass $class) : float
    {
        $afferent = 0;
        $classname = $class->namespace . '\\' . $class->name;
        $classes = ClassesRepository::instance();

        foreach ($classes() as $current) {
            if (in_array($classname, $current->dependencies)) {
                $afferent ++;
            }
        }

        $class->pushMetric('afferent', $afferent / self::$weight);

        return $afferent;
    }
}
