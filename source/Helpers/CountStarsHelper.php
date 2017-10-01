<?php
namespace Insphptor\Helpers;

use Insphptor\Storage\ClassesRepository;

class CountStarsHelper
{
    public static function calculeClassesStars()
    {
        $classes = ClassesRepository::instance();
        $weight = [];

        foreach ($classes() as $key => $class) {
            $weight[$key] = array_sum($class->metrics);
        }

        asort($weight);

        $max = config()['rating'] != 'auto' ? config()['rating'] : end($weight);

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

        return round($all / $classes->count(), 1);
    }
}
