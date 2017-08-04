<?php

namespace Insphptor\Program\Commands;

use Webmozart\Console\Api\Args\Args;
use Webmozart\Console\Api\Command\Command;
use Webmozart\Console\Api\IO\IO;
use Webmozart\Console\UI\Component\Table;

class RunCommand
{
    private $classes = [];

    private $metrics = [
        '\Insphptor\Metrics\DetourMetric',
    ];

    private $components = [
        '\Insphptor\Components\NameComponent',
        '\Insphptor\Components\MethodsComponent',
        '\Insphptor\Components\AttributesComponent',
        '\Insphptor\Components\TypeComponent',
        '\Insphptor\Components\NamespaceComponent',
    ];

    public function handle(Args $args, IO $io, Command $command)
    {
        $io->writeLine( 'Loading files...' );
        return 0;
    }
}