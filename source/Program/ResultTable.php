<?php

namespace Insphptor\Program;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Insphptor\Storage\ClassesRepository;

/**
 * @codeCoverageIgnore
 */
class ResultTable
{
    public static function displayMetricsTable(OutputInterface $output, ClassesRepository $repository)
    {
        $table = new Table($output);
        $table->setHeaders(['<fg=blue>Type</>', '<fg=blue>Name</>', '<fg=blue>Stars</>']);

        $count = 0;
        $result = $repository->sortByStars();

        $lines = [];
        foreach ($result as $class) {
            if ($count == config()['rank']) {
                break;
            }

            $lines[] = [
                $class->type,
                $class->namespace . '\\' . $class->name,
                $class->star
            ];
            $count ++;
        }

        $table->setRows($lines);
        $table->render();
    }

    public static function displayDevsTable(OutputInterface $output, array $devs)
    {
        if (count($devs) == 0) {
            return;
        }

        $table = new Table($output);
        $table->setHeaders([
            '<fg=blue>Developer</>' , '<fg=blue>Commits</>',
            '<fg=blue>Inserts</>'   , '<fg=blue>Deletions</>'
        ]);

        $count = 0;

        $lines = [];
        foreach ($devs as $name => $dev) {
            if ($count == config()['rank']) {
                break;
            }

            $lines[] = [
                $name,
                $dev['commits'],
                $dev['inserts'],
                $dev['deletions']
            ];
            $count ++;
        }

        $table->setRows($lines);
        $table->render();
    }
}
