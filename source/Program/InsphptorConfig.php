<?php

namespace Insphptor\Program;

use Webmozart\Console\Config\DefaultApplicationConfig;

class InsphptorConfig extends DefaultApplicationConfig
{
    protected function configure()
    {
        parent::configure();
        
        $this
            ->setName('Insphptor')
            ->setVersion('1.0.0')
        ;
    }
}