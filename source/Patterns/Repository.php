<?php
namespace Insphptor\Patterns;

abstract class Repository
{
    protected $items;

    public function __construct()
    {
        $this->create();
    }

    abstract public function create();

    public function __invoke() : array
    {
        return $this->items;
    }
}
