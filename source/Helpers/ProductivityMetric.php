<?php
namespace Insphptor\Helpers;

use Insphptor\Helpers\StorageHelper;

class ProductivityMetric
{
    use GitTrait;

    private static $developers = [];

    private static function summary()
    {
        $summary = self::git('shortlog', ['--numbered', '--summary', '-e', 'HEAD']);

        $devs = 0;
        foreach ($summary as $item) {
            if ($devs >= 10) {
                break;
            }

            list ($commits, $author) = explode("\t", trim($item), 2);

            self::$developers[$author]['commits'] = (int) $commits;
        }
    }

    public static function devs()
    {
        self::summary();

        foreach (self::$developers as $dev => $stats) {
            $e = self::git('log', ['--author', $dev,  '--oneline', '--shortstat']);
            self::$developers[$dev]['inserts'] = 0;
            self::$developers[$dev]['deletions'] = 0;

            foreach ($e as $key => $line) {
                if (($key % 2) != 0) {
                    $line = explode(',', $line);
                    unset($line[0]);
                    $line[1] = isset($line[1]) ? trim($line[1]) : 0;
                    $line[2] = isset($line[2]) ? trim($line[2]) : 0;
                    self::$developers[$dev]['inserts']   += $line[1];
                    self::$developers[$dev]['deletions'] += $line[2];
                }
            }
        }

        return self::$developers;
    }
}
