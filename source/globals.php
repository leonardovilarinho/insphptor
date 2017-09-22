<?php

/**
 * Define alias from end of line
 */
if (! defined('EOL')) {
    define('EOL', PHP_EOL);
}

/**
 * Define alias from tab character
 */
if (! defined('TAB')) {
    define('TAB', "\t");
}

/**
 * Define alias from get application settings
 */
if (! function_exists('config')) {
    function config() : array
    {
        return \Insphptor\Program\Core::config();
    }
}

/**
 * Define alias from color method extension
 */
if (! function_exists('color')) {
    function color(string $msg)
    {
        $c = \Insphptor\Program\Core::color($msg);
        return $c($msg);
    }
}

/**
 * Function to progress bar
 */
if (! function_exists('progress')) {
    /**
     * Show progress bar with three colors
     * @param  int    $step      interval between points
     * @param  int    &$progress current progress the bar
     * @param  string $char      character from displayed in bar
     */
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
