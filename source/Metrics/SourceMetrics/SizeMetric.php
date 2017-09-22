<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class SizeMetric implements IMetric
{
    /**
     * Calcule size from an class
     * @param  AnalyzedClass &$class target class from calculate
     * @return float                size
     */
    public static function value(AnalyzedClass &$class) : float
    {
        $size = 0;
        foreach ($class->methods as $method) {
            $size += count($method['content']);
        }

        $class->pushMetric('size', $size / 5);
        return $size;
    }
}
