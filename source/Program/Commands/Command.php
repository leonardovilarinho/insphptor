<?php
namespace Insphptor\Program\Commands;

use Webmozart\Console\Api\Args\Args;

abstract class Command
{
    /**
     * Show an splash screen from aplication, displayed name and author
     */
    protected function showSplashScreen()
    {
        echo EOL. '---' . EOL;
        echo '- '  . color('Insphptor')->bold->magenta . EOL;
        echo '- '  . color('By Leonardo Vilarinho')->bold . EOL;
        echo '---' . EOL.EOL;
    }

    /**
     * Abstraction for action current command
     * @param  Args   $args arguments reveiced
     * @return int          output for command
     */
    abstract public function handle(Args $args) : int;
}
