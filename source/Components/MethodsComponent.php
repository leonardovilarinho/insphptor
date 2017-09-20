<?php

namespace Insphptor\Components;

class MethodsComponent implements IComponent
{
    public static function find(array $tokenize) : array
    {
        $val = [];
        $visibility = '';
        $valid = false;
        $content = [];
        $count = 1;
        $find = false;

        foreach ($tokenize as $key => $value) {
            if (isset($value[0])) {
                if ($visibility != '' and $value[0] != T_WHITESPACE and isset($value[1])) {
                    if ($value[0] == T_FUNCTION) {
                        $valid = true;
                    } else {
                        if (in_array($value[0], [T_STATIC, T_ABSTRACT])) {
                            $visibility .= ' ' . str_replace('T_', '', token_name($value[0]));
                        } elseif ($visibility != '' and $valid) {
                            $val[$count] = [
                            'name' => $value[1],
                            'visibility' => strtolower($visibility)
                            ];
                            $find = true;
                            $visibility = '';
                            $valid = false;
                            $count ++;
                        }
                    }
                } elseif (in_array($value[0], [T_PUBLIC, T_PRIVATE, T_PROTECTED])) {
                    if($visibility == '')
                        $visibility = str_replace('T_', '', token_name($value[0]));
                }

                if (($key + 1) >= count($tokenize) or in_array($value[0], [T_PUBLIC, T_PRIVATE, T_PROTECTED])) {
                    if ($count > 1) {
                        $val[$count - 1]['content'] = $content;
                    }
                    $content = [];
                    $find = false;
                }

                if ($find) {
                    $content[] = $value;
                }
            }
        }

        return $val;
    }
}
