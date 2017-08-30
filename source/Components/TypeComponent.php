<?php

namespace Insphptor\Components;

class TypeComponent implements IComponent
{
    public static function find(array $tokenize) : string
    {
        $val = '';
        foreach ($tokenize as $value) {
            if (isset($value[0])) {
                if (in_array($value[0], [T_FINAL, T_STATIC, T_ABSTRACT])) {
                    $val = str_replace('T_', '', token_name($value[0])) . ' ' . $val;
                }

                if (in_array($value[0], [T_CLASS, T_INTERFACE, T_TRAIT])) {
                    $val .= str_replace('T_', '', token_name($value[0]));
                    break;
                }
            }
        }

        return strlen($val) > 0 ? trim(strtolower($val)) : 'file';
    }
}
