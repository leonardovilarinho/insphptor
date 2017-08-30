<?php
namespace Insphptor\Analyzer;

use Insphptor\Storage\ClassesRepository;
use Insphptor\Storage\ComponentsRepository;

class GeneralAnalyzer
{
    private $repository;

    public function __construct(ClassesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function generateComponents()
    {
        $components = new ComponentsRepository;
        $repository = $this->repository;

        foreach ($repository() as $class) {
            foreach ($components() as $name => $component) {
                $class->pushAttribute($name, $component::find($class->token));
            }
        }
    }

    public function showComponents()
    {
        $repository = $this->repository;

        foreach ($repository() as $class) {
            $class->print();
        }
    }
}
