<?php

namespace Insphptor\Patterns;

class Singleton
{
    /**
     * Get current static instance from this Singleton
     * @return Singleton current instance
     */
    public static function instance() : Singleton
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Function for initialize this Singleton
     */
    protected function init()
    {
    }

    /**
     * Construtor call init method for initalizable this Singleton
     */
    protected function __construct()
    {
        $this->init();
    }

    /**
     * Locked clone from class
     */
    private function __clone()
    {
    }

    /**
     * Locked wakeup from class
     */
    private function __wakeup()
    {
    }
}
