<?php

namespace Insphptor\Program\Helpers;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * @codeCoverageIgnore
 */
class BoxObject
{
    public static function display(string $message, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders([sprintf('<fg=blue>%s</>', $message)]);
        $table->render();
    }
}
