<?php

namespace Insphptor\Components;

class NamespaceComponent implements IComponent
{
    public static function find(array $tokenize) : string
    {
        $val = '';
        $isFind = false;
        foreach ($tokenize as $value) {
            if ($isFind and $value != ';') {
                $val .= $value[1];
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
