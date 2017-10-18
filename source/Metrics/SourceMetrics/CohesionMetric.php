<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class CohesionMetric implements IMetric
{
    private static $weight = 1;

    /**
     * Calcule cohesion from an class
     * @param  AnalyzedClass &$class target class from calculate
     * @return float                cohesion
     */
    public static function value(AnalyzedClass $class) : float
    {
        $cohesion = count($class->methods);
        $methodVariables = [];
        $exclude = 0;

        foreach ($class->methods as $key => $method) {
            $valid = 0;
            $name = '';
            $prefix  = substr($method['name'], 0, 3);
            $prefix2 = substr($method['name'], 0, 4);
            $prefix  = strtolower($prefix);

            if (!in_array($prefix, ['get', 'set']) and $prefix2 != 'push') {
                foreach ($method['content'] as $token) {
                    if (in_array($token[0], [T_VARIABLE, T_STRING])) {
                        if (in_array($token[1], ['$this', 'self'])) {
                            $valid = 1;
                        }
                    }

                    if ($valid > 0 and $valid < 4) {
                        $name .= isset($token[1]) ? $token[1] : '';
                        $valid ++;
                        if ($valid == 4) {
                            $methodVariables[$key][] = $name;
                            $name = '';
                            $valid = 0;
                        }
                    }
                }
            } else {
                $exclude ++;
            }
        }

        $cohesion -= $exclude;

        foreach ($methodVariables as $key1 => $method) {
            $isFind = false;
            foreach ($method as $variable) {
                foreach ($methodVariables as $key2 => $compare) {
                    if ($key2 > $key1 and in_array($variable, $compare)) {
                        $isFind = true;
                    }
                }
            }

            if ($isFind) {
                $cohesion --;
            }
        }

        $cohesion = $cohesion / self::$weight;

        $class->pushMetric('cohesion', $cohesion == 0 ? 1 : $cohesion);
        return $cohesion;
    }
}
