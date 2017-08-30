<?php
namespace Insphptor\Storage;

use Insphptor\Patterns\RepositoryAndSingleton;
use Insphptor\Analyzer\AnalyzedClass;

class ClassesRepository extends RepositoryAndSingleton
{
    public function create()
    {
        $this->init();
    }

    public function init()
    {
        $this->items = [];
    }

    public function pushClass(AnalyzedClass $class)
    {
        $this->items[] = $class;
    }

    public function getClasses() : array
    {
        return $this->items;
    }

    public function count() : int
    {
        return count($this->items);
    }
}
