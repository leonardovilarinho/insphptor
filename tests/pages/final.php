<?php

use My\Package\Dependencie;

final class MyFinalClass
{
    public static $staticValue;
    
    protected static function myMethod()
    {
        self::$staticValue = 'Hello';
        $test = new Other\Package\Dependencie;
    }
    
    public function moreOneMethod()
    {
        return 'Hello';
    }
}
