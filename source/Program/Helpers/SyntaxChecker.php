<?php

namespace Insphptor\Program\Helpers;

use Syntax\Php;

class SyntaxChecker implements Helper
{
	private $instance == null;

	public static function run(array $args)
	{
		if(self::$instance == null)
			self::$instance = new Php();

		return $syntax->check($args[0];
	}
}
