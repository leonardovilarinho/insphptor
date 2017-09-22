<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class EfferentMetric implements IMetric
{
    /**
     * Array of tokens why define ocorrence this metric
     * @var array
     */
    private static $included = [
        T_REQUIRE       , T_REQUIRE_ONCE    , T_USE         , T_INCLUDE     ,
        T_INCLUDE_ONCE  ,
    ];

    /**
     * Calcule efferent from an class
     * @param  AnalyzedClass &$class target class from calculate
     * @return float                efferent
     */
    public static function value(AnalyzedClass &$class) : float
    {
        $efferent = 0;

        foreach ($class->token as $token) {
            if (is_array($token)) {
                if (\in_array($token[0], self::$included)) {
                    $efferent ++;
                }
            }
        }

        $class->pushMetric('efferent', $efferent);
        return $efferent;
    }
}
