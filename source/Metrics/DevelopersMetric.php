<?php

namespace Insphptor\Metrics;

use Insphptor\Helpers\GitTrait;
use Insphptor\Program\Helpers\ProgressHelper;
use Symfony\Component\Console\Output\OutputInterface;

class DevelopersMetric
{
    use GitTrait;

    private static $developers = [];
    private static $output;

    private static function summary()
    {
        $summary = self::git('shortlog', ['--numbered', '--summary', '-e', 'HEAD']);

        $progress = ProgressHelper::start(self::$output, 'summarize devs', count($summary));
        $devs = 0;
        foreach ($summary as $item) {
            if ($devs >= config()['rank']) {
                break;
            }

            list ($commits, $author) = explode("\t", trim($item), 2);

            self::$developers[$author]['commits'] = (int) $commits;
            $progress->advance();
            $devs ++;
        }
        $progress->finish();
    }

    public static function generate(OutputInterface $output)
    {
        self::$output = $output;

        if (!HAS_GIT) {
            return [];
        }
        if (count(self::$developers) > 0) {
            return self::$developers;
        }

        self::summary();

        $progress = ProgressHelper::start(self::$output, 'actions from devs', count(self::$developers));
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
                    self::$developers[$dev]['inserts']   += (int)$line[1];
                    self::$developers[$dev]['deletions'] += (int)$line[2];
                }
            }
            $progress->advance();
        }
        $progress->finish();

        return self::$developers;
    }

    public static function getDevelopers()
    {
        return self::$developers;
    }
}
