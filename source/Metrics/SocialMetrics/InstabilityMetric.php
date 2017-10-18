<?php
namespace Insphptor\Metrics\SocialMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Storage\ClassesRepository;
use Insphptor\Helpers\GitTrait;

class InstabilityMetric implements IMetric
{
    use GitTrait;
    public static function value(AnalyzedClass $class) : float
    {
        $instability = 0;

        $e = self::git('log', ['--follow', $class->filename]);
        $instability = count($e);

        $class->pushMetric('instability', $instability);

        return $instability;
    }
}
