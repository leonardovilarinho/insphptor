<?php

namespace Insphptor\Components;

class DependenciesComponent implements IComponent
{
    /**
     * Find dependencies in class tokenize
     * @param  array  $tokenize array of tokens form class
     * @return array           array with dependencies
     */
    public static function find(array $tokenize) : array
    {
        $dependencies = [];
        $isFind = false;
        $val = '';

        foreach ($tokenize as $value) {
            if ($isFind and $value != ';') {
                $val .= isset($value[1]) ? $value[1] : '';
            } elseif ($isFind and $value == ';') {
                $dependencies[] = trim($val);
                $val = '';
                $isFind = false;
            }

            if (isset($value[0])) {
                if (in_array($value[0], [T_USE, T_NEW])) {
                    $isFind = true;
                }
            }
        }

        return $dependencies;
    }
}
