<?php
namespace Insphptor\Metrics\SocialMetrics;

use Insphptor\Metrics\IMetric;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Storage\ClassesRepository;
use Insphptor\Helpers\GitTrait;

class BugMetric implements IMetric
{
    use GitTrait;

    private static $terms = ['bug', 'fix', 'error'];

    public static function value(AnalyzedClass &$class) : float
    {
        $bug = 0;

        $e = self::git('log', [
            '--all',
            '--grep'    , 'fix',
            '--grep'    , 'error',
            '--grep'    , 'bug',
            '--follow'  , $class->filename
        ]);

        if (count($e) > 0) {
            $bug ++;
        }

        $class->pushSourceMetric('bug', $bug);

        return $bug;
    }
}
