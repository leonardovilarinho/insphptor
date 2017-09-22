<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class ComplexityMetric implements IMetric
{
    /**
     * Array of tokens why define ocorrence this metric
     * @var array
     */
    private static $included = [
        T_IF            , T_ELSEIF      , T_ELSE            , T_FOR                 ,
        T_FOREACH       , T_SWITCH      , T_BOOLEAN_AND     , T_BOOLEAN_OR          ,
        T_BREAK         , T_CASE        , T_CATCH           , T_CONTINUE            ,
        T_DO            , T_FINALLY     , T_IS_EQUAL        , T_IS_GREATER_OR_EQUAL ,
        T_IS_IDENTICAL  , T_IS_NOT_EQUAL, T_IS_NOT_IDENTICAL, T_IS_SMALLER_OR_EQUAL ,
        T_SPACESHIP     , T_LOGICAL_AND , T_LOGICAL_OR      , T_LOGICAL_XOR         ,
        T_THROW         , T_GOTO        ,
    ];

    /**
     * Calcule complexity from an class
     * @param  AnalyzedClass &$class target class from calculate
     * @return float                complexity
     */
    public static function value(AnalyzedClass &$class) : float
    {
        $complexity = 0;
        foreach ($class->methods as $method) {
            $complexity ++;
            foreach ($method['content'] as $token) {
                if (is_array($token)) {
                    if (\in_array($token[0], self::$included)) {
                        $complexity ++;
                    }
                }
            }
        }
        $class->pushMetric('complexity', $complexity);
        return $complexity;
    }
}
