<?php
namespace Insphptor\Metrics;

use Insphptor\Analyzer\AnalyzedClass;

interface IMetric
{
    public static function value(AnalyzedClass &$_class);
}
