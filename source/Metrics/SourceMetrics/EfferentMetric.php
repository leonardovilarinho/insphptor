<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class EfferentMetric implements IMetric
{
    private static $included = [
        T_REQUIRE, T_REQUIRE_ONCE, T_USE, T_INCLUDE, T_INCLUDE_ONCE
    ];

    public static function value(AnalyzedClass &$class)
    {
        $efferent = 0;

        foreach($class->token as $token) {
            if(is_array($token)) {
                if(\in_array($token[0], self::$included ))
                    $efferent ++;
            }
        }    

        $class->pushMetric('efferent', $efferent);
    }
}