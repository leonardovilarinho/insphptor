<?php

namespace Insphptor\Components;

class NamespaceComponent implements IComponent
{
    /**
     * Find class namespace in class tokenize
     * @param  array  $tokenize array of tokens form class
     * @return string           class namespace
     */
    public static function find(array $tokenize) : string
    {
        $val = '';
        $isFind = false;
        foreach ($tokenize as $value) {
            if ($isFind and $value != ';') {
                $val .= isset($value[1]) ? $value[1] : '';
            } elseif ($isFind and $value == ';') {
                break;
            }

            if (isset($value[0])) {
                if ($value[0] == T_NAMESPACE) {
                    $isFind = true;
                }
            }
        }

        return trim($val);
    }
}
