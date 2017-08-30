<?php

if (! defined('EOL')) {
    define('EOL', PHP_EOL);
}

if (! defined('TAB')) {
    define('TAB', "\t");
}

if (! function_exists('config')) {
    function config() : array
    {
        return \Insphptor\Program\Core::config();
    }
}

if (! function_exists('color')) {
    function color(string $msg)
    {
        $c = \Insphptor\Program\Core::color($msg);
        return $c($msg);
    }
}

if (! function_exists('progress')) {
    function progress(int $step, int &$progress, string $char = '|')
    {
        $progress += $step;
        for ($i = 0; $i < $step; $i++) {
            if ($progress <= 25) {
                echo color($char)->bg_red;
            } elseif ($progress <= 60) {
                echo color($char)->bg_yellow;
            } else {
                echo color($char)->bg_green;
            }
        }
    }
}
