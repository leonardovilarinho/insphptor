<?php

namespace Insphptor\Program\Config;

use Insphptor\Patterns\Singleton;

class GitConfig extends Singleton
{
    /**
     * Define if project is an git repository
     */
    protected function init()
    {
        if (is_dir(config()['project'].'/.git') and config()['git'] != 'not') {
            define('HAS_GIT', true);
        } else {
            define('HAS_GIT', false);
        }
    }
}
