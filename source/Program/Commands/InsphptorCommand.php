<?php
namespace Insphptor\Program\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * @codeCoverageIgnore
 */
abstract class InsphptorCommand extends Command
{
    /**
     * Alias to call an command programatic
     * @param  string          $commandName name from command
     * @param  OutputInterface $output      printer object to display info in console
     */
    protected function call(string $commandName, OutputInterface $output)
    {
        $command = $this->getApplication()->find($commandName);

        $arguments = ['command' => $commandName];

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }
}
