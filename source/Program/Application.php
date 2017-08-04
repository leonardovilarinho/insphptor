<?php

namespace Insphptor\Program;

use Webmozart\Console\Config\DefaultApplicationConfig;

class Application extends DefaultApplicationConfig
{
    protected function configure()
    {
        parent::configure();

        $app = Core::instance();

        $this
            ->setDisplayName(
                color('InsPHPtor')->bold->magenta .
                ' by ' .
                color('Leonardo Vilarinho')->bold
            )
            ->setName('Insphptor')
            ->setVersion('1.0.0')
        ;

        $this->defineCommands();
    }

    private function defineCommands()
    {
        $this
            ->beginCommand('run')
                ->setDescription('Run analizer metrics')
                ->setHandler(new \Insphptor\Program\Commands\RunCommand())
            ->end()
        ;
    }

}