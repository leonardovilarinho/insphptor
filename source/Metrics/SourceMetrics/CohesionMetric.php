<?php
namespace Insphptor\Metrics\SourceMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;

class CohesionMetric implements IMetric
{

    /**
     * Calcule cohesion from an class
     * @param  AnalyzedClass &$class target class from calculate
     * @return float                cohesion
     */
    public static function value(AnalyzedClass &$class) : float
    {
        $cohesion = count($class->methods);
        $methodVariables = [];
        $exclude = 0;

        foreach ($class->methods as $key => $method) {
            $valid = 0;
            $name = '';
            $prefix = substr($method['name'], 0, 3);
            $prefix = strtolower($prefix);

            if (!in_array($prefix, ['get', 'set'])) {
                foreach ($method['content'] as $token) {
                    if (in_array($token[0], [T_VARIABLE, T_STRING])) {
                        if (in_array($token[1], ['$this', 'self'])) {
                            $valid = 1;
                        }
                    }

                    if ($valid > 0 and $valid < 4) {
                        $name .= $token[1];
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

        $class->pushMetric('cohesion', $cohesion);
        return $cohesion;
    }
}
