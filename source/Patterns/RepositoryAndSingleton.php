<?php
namespace Insphptor\Patterns;

abstract class RepositoryAndSingleton extends Singleton
{
    /**
     * Array of items in this repository
     * @var items
     */
    protected $items;

    /**
     * Abstraction for create method
     */
    abstract public function create();

    /**
     * Invoke this repository why function, this function return an array of items
     * @return array repository elements
     */
    public function __invoke() : array
    {
        return $this->items;
    }
}
