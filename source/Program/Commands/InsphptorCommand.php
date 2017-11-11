<?php
namespace Insphptor\Program\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Insphptor\Program\Config\Config;

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

    protected function pathToView(string $view) : string
    {
        Config::instance();
        $view = isset(config()['views'][$view]) ? config()['views'][$view] : $view;
        $isLocal = false;
        if ($view == 'insphptor-overview' or $view == 'overview') {
            $isLocal = true;
            $view = __DIR__.'/../../../views/overview';
        }

        $view .= substr($view, 0, -1) == '/' ? '' : '/';

        return ($isLocal ? '' : config()['project']) . '/' . $view;
    }
}
