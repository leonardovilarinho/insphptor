<?php

namespace Insphptor\Program\ExportServices;

use Insphptor\Storage\ClassesRepository;
use Symfony\Component\Console\Output\OutputInterface;

interface IExport
{
    public function __construct(ClassesRepository $repository, array $devs, OutputInterface $output);

    public function export(string $path, float $stars, string $alias = null);
}
