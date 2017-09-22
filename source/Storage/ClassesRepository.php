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

    /**
     * Get all classes from this repository
     * @return array array with all classes
     */
    public function getClasses() : array
    {
        return $this->items;
    }

    /**
     * Get number of classes in this repository
     * @return int number of classes
     */
    public function count() : int
    {
        return count($this->items);
    }
}
