<?php

namespace Insphptor\Program\Helpers;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

class ProgressHelper
{

    public static function start(OutputInterface $output, string $title, int $total)
    {
        $output->writeln('Loading '.$title.'...');
        $bar = new ProgressBar($output, $total);
        $bar->setBarCharacter('<fg=blue;bg=blue>|</>');
        $bar->setProgressCharacter('&');
        $bar->setFormat('<fg=blue>%memory:6s%</>  %current:5s%/%max:5s% |%bar%| %percent:3s%% %estimated:-6s%'.EOL.EOL);

        $bar->start();
        return $bar;
    }
}
