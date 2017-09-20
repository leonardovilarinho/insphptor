<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class SizeMetric implements IMetric
{
    public static function value(AnalyzedClass &$class)
    {
        $size = 0;
        foreach($class->methods as $method)
            $size += count($method['content']);

        $class->pushMetric('size', $size / 5);
    }
}