<?php

namespace Insphptor\Components;

class NameComponent implements IComponent
{
    /**
     * Find class name in class tokenize
     * @param  array  $tokenize array of tokens form class
     * @return string           class name
     */
    public static function find(array $tokenize) : string
    {
        $val = '';
        $isFind = false;
        foreach ($tokenize as $value) {
            if ($isFind and $value[0] != T_WHITESPACE) {
                if(isset($value[1]))
                    $val .= $value[1];
            } elseif ($val != '' and $value[0] == T_WHITESPACE) {
                break;
            }

            if (isset($value[0])) {
                if (in_array($value[0], [T_CLASS, T_INTERFACE, T_TRAIT])) {
                    $isFind = true;
                }
            }
        }

        return trim($val);
    }
}
