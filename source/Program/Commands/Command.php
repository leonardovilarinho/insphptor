<?php
namespace Insphptor\Program\Commands;

use Webmozart\Console\Api\Args\Args;

abstract class Command
{
    protected function showSplashScreen()
    {
        echo EOL. '---' . EOL;
        echo '- '  . color('Insphptor')->bold->magenta . EOL;
        echo '- '  . color('By Leonardo Vilarinho')->bold . EOL;
        echo '---' . EOL.EOL;
    }

    abstract public function handle(Args $args);
}
