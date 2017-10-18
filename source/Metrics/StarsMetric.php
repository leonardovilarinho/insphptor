<?php
namespace Insphptor\Metrics;

use Insphptor\Storage\ClassesRepository;

class StarsMetric
{
    private static $projectStars = 0;
    private static $levels = [
        'NEWBIE'    => 3.5,
        'NORMAL'    => 2.6,
        'HARDCORE'  => 1.8
    ];

    public static function calculeClassesStars()
    {
        $classes = ClassesRepository::instance();
        $weight = [];

        foreach ($classes() as $key => $class) {
            $weight[$key] = array_sum($class->metrics);
        }

        asort($weight);

        $max =  end($weight) * self::$levels[ strtoupper(config()['level']) ];

        $weight = array_map(function ($item) use ($max) {
            $inversion = ($max - $item);
            $ofThree = ( 100 * $inversion ) / $max;
            $scaleToFive = $ofThree / 2;

            return round($scaleToFive / 10, 1);
        }, $weight);

        foreach ($classes() as $key => &$class) {
            $class->pushAttribute('star', $weight[$key]);
        }
    }

    public static function calculeProjectStars() : float
    {
        $classes = ClassesRepository::instance();
        $all = 0;
        foreach ($classes() as $class) {
            $all += $class->star;
        }

        $classes = $classes->count() > 0 ? $classes->count() : 1;

        self::$projectStars = round($all / $classes, 1);

        return self::$projectStars;
    }
}
