<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class EncapsulationMetric implements IMetric
{
    private static $weight = 1;

    /**
     * Calcule encapsulation from an class
     * @param  AnalyzedClass &$class target class from calculate
     * @return float                encapsulation
     */
    public static function value(AnalyzedClass &$class) : float
    {
        $private = 1;
        $public = 0;
        foreach ($class->methods as $key => $method) {
            if ($method['visibility'] === 'public') {
                $public += count($method['content']);
            } else {
                $private += count($method['content']);
            }
        }

        $encapsulation = 0;

        if ($public > $private) {
            $encapsulation = $public / ($private * 5);
            $encapsulation = \number_format($encapsulation, 2);
        }

        $class->pushMetric('encapsulation', $encapsulation / self::$weight);
        return (float)$encapsulation;
    }
}
