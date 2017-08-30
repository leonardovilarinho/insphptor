<?php
namespace Insphptor\Patterns;

abstract class RepositoryAndSingleton extends Singleton
{
    protected $items;

    abstract public function create();

    public function __invoke() : array
    {
        return $this->items;
    }
}
