<?php

namespace Insphptor\Components;

class AttributesComponent implements IComponent
{
    /**
     * Find attributes in class tokenize
     * @param  array  $tokenize array of tokens form class
     * @return array           array with arguments [name => x, visibility => y]
     */
    public static function find(array $tokenize) : array
    {
        $val = [];
        $visibility = '';
        $count = 1;

        foreach ($tokenize as $value) {
            if (isset($value[0])) {
                if ($visibility != '' and $value[0] != T_WHITESPACE and isset($value[1])) {
                    if (in_array($value[0], [T_WHITESPACE, T_FUNCTION, T_ABSTRACT])) {
                        $visibility = '';
                    }

                    if ($value[0] == T_STATIC) {
                        $visibility .= ' static';
                    } elseif ($visibility != '') {
                        $val[$count] = [
                        'name' => $value[1],
                        'visibility' => strtolower($visibility)
                        ];
                        $count ++;
                        $visibility = '';
                    }
                } elseif (in_array($value[0], [T_PUBLIC, T_PRIVATE, T_PROTECTED, T_CONST])) {
                    $visibility = str_replace('T_', '', token_name($value[0]));
                }
            }
        }

        return $val;
    }
}
