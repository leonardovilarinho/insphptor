<?php

if( ! defined('EOL') )
	define('EOL', PHP_EOL);

if( ! defined('TAB') )
	define('TAB', "\t");

if( ! function_exists('config') ) {
	function config() {
		return \Insphptor\Program\Core::config();
	}
}

if( ! function_exists('color') ) {
	function color($msg) {
		$c = \Insphptor\Program\Core::color($msg);
		return $c($msg);
	}
}