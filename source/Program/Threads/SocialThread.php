<?php

namespace Insphptor\Program\Threads;

class SocialThread extends \Threaded
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            echo "{$i} na Social\n";
        }

        echo "Terminou a Social\n";
    }
}
