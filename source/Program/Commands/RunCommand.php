<?php

namespace Insphptor\Program\Commands;

use Webmozart\Console\Api\Args\Args;
use Webmozart\Console\Api\Command\Command;
use Webmozart\Console\Api\IO\IO;
use Webmozart\Console\UI\Component\Table;

class RunCommand
{
    private $classes = [];

    public function handle(Args $args, IO $io, Command $command)
    {
        $io->writeLine( 'Loading files...' );
        return 0;
    }

    public function export(Args $args, IO $io)
    {
        $io->writeLine( 'Loading json...' );
    }
}