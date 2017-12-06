<?php
// @codeCoverageIgnoreStart
/**
 * Define logo this app
 */
if (!defined('APP_NAME')) {
    define('APP_NAME', '
	 ___
	  )  _   _ <fg=blue>  _ ( _   _ </> _)_ _   _
	_(_ ) ) (  <fg=blue> )_) ) ) )_)</> (_ (_) )
	        _) <fg=blue>(       (   </>
	                                           v1.0.12
	                            By <fg=blue>Leonardo Vilarinho</>'.PHP_EOL);
}

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
        return \Insphptor\Program\Config\Settings::getConfig();
    }
}
// @codeCoverageIgnoreEnd
