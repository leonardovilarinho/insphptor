<?php
namespace Insphptor\Metrics;

use Insphptor\Analyzer\AnalyzedClass;

interface IMetric
{
    /**
     * Define method for calculate an metric and return an value float
     * @param  AnalyzedClass &$_class reference to class why can calculate
     * @return float                 result of current metric
     */
    public static function value(AnalyzedClass &$_class) : float;
}
