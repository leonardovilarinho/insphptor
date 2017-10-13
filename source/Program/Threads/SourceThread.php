<?php

namespace Insphptor\Program\Threads;

class SourceThread extends \Threaded
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            echo "{$i} na Source\n";
        }

        echo "Terminou a Source\n";
    }
}
