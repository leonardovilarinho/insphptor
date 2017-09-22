<?php
namespace Insphptor\Components;

interface IComponent
{
    /**
     * Method for find an component in array of tokens
     * @param  array  $tokenize tokens from class analysed
     * @return mixed           component result
     */
    public static function find(array $tokenize);
}
