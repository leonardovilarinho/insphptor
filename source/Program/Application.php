<?php

namespace Insphptor\Program;

use Webmozart\Console\Config\DefaultApplicationConfig;
use Webmozart\Console\Api\Args\Format\Argument;
use Webmozart\Console\Api\Args\Format\Option;

class Application extends DefaultApplicationConfig
{
    /**
     * Configure insphptor application, resquesting the core configuration,
     * set name and description.
     * @return int console output program
     */
    protected function configure() : int
    {
        parent::configure();

        Core::instance();

        $this
            ->setDisplayName(
                color('InsPHPtor')->bold->magenta .
                ' by ' .
                color('Leonardo Vilarinho')->bold
            )
            ->setName('Insphptor')
            ->setVersion('1.0.0');

        $this->defineCommands();

        return 0;
    }

    /**
     * Create run command and your subcommands and arguments and options
     * @return [type] [description]
     */
    private function defineCommands()
    {
        $this
            ->beginCommand('run')
            ->setDescription('Run analizer metrics')
            ->setHandler(new \Insphptor\Program\Commands\RunCommand())
            ->beginSubCommand('export')
            ->setHandlerMethod('export')
            ->setDescription('Export result in ' . config()['export'] . ' file')
            ->addArgument('view', Argument::OPTIONAL, 'The view system', 'default')
            ->addOption('open', 'o', Option::BOOLEAN, 'Open server with result in view')
            ->end()
            ->end();
    }
}
