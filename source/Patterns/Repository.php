<?php
namespace Insphptor\Patterns;

abstract class Repository
{
    /**
     * Array of items in this repository
     * @var items
     */
    protected $items;

    /**
     * Constructor call the create method for default creation this repository
     */
    public function __construct()
    {
        $this->create();
    }

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
