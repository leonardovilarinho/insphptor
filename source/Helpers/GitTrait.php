<?php

namespace Insphptor\Helpers;

use Symfony\Component\Process\ProcessBuilder;

trait GitTrait
{
    public function git(string $command, array $options = [])
    {

        $builder = ProcessBuilder::create()
        ->setPrefix('git')
        ->setWorkingDirectory(config()['project']);

        $builder->add($command);

        foreach ($options as $option) {
            $builder->add($option);
        }

        $process = $builder->getProcess();
        $process->run();

        if (!$process->isSuccessful()) {
            return [];
        }

        return preg_split('/\r?\n/', rtrim($process->getOutput()), -1, PREG_SPLIT_NO_EMPTY);
    }
}
