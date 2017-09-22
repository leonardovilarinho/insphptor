<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class EncapsulationMetric implements IMetric
{
    /**
     * Calcule encapsulation from an class
     * @param  AnalyzedClass &$class target class from calculate
     * @return float                encapsulation
     */
    public static function value(AnalyzedClass &$class) : float
    {
        $private = 1;
        $public = 1;
        foreach ($class->methods as $key => $method) {
            if ($method['visibility'] === 'public') {
                $public += count($method['content']);
            } else {
                $private += count($method['content']);
            }
        }

        $encapsulation = $public / ($private * 1.5);
        $encapsulation = \number_format($encapsulation, 2);

        $class->pushMetric('encapsulation', $encapsulation);
        return $encapsulation;
    }
}
