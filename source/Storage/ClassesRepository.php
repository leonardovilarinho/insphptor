<?php
namespace Insphptor\Storage;

use Insphptor\Patterns\RepositoryAndSingleton;
use Insphptor\Analyzer\AnalyzedClass;

class ClassesRepository extends RepositoryAndSingleton
{
    /**
     * Method for inializable repository, call init method from inializable singleton
     */
    public function create()
    {
        $this->init();
    }

    /**
     * Define default items, empty
     */
    public function init()
    {
        $this->items = [];
    }

    /**
     * Add an class in this repository
     * @param  AnalyzedClass $class class to add in repository
     */
    public function pushClass(AnalyzedClass $class)
    {
        $this->items[] = $class;
    }


    public function removeClass(AnalyzedClass $class)
    {
        $index = array_search($class, $this->items);
        echo 'Removendo ' . $class->type . ' ' . $index . '\n';
        if ($index !== false) {
            unset($this->items[$index]);
        }
    }

    /**
     * Get all classes from this repository
     * @return array array with all classes
     */
    public function getClasses() : array
    {
        return $this->items;
    }

    public function sortByWeight() : array
    {
        usort($this->items, function ($a, $b) {
            return $a->weight < $b->weight;
        });

        return $this->items;
    }
}
