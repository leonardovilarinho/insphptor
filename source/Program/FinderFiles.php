<?php

namespace Insphptor\Program;

use Symfony\Component\Finder\Finder;

class FinderFiles
{
    private $project;
    private $finder;

    public function __construct()
    {
        $this->project = config()['project'];

        $this->finder = new Finder;
        $this->finder->files();

        if (!$this->includeOnlyFiles()) {
            $this->excludeFiles();
        }

        $this->addExtensions();
    }

    public function getFiles()
    {
        return $this->finder;
    }

    private function includeOnlyFiles()
    {
        $onlyConfig = config()['only'];

        if (count($onlyConfig) > 0) {
            foreach ($onlyConfig as $value) {
                $this->finder->in(config()['project'] . '/' . $value);
            }
            return true;
        }

        return false;
    }

    private function excludeFiles()
    {
        $ignoredConfig = config()['ignored'];

        $this->finder->in($this->project);
        foreach ($ignoredConfig as $value) {
            $this->finder->exclude($value);
        }
    }

    private function addExtensions()
    {
        $extensionsConfig = config()['extensions'];

        foreach ($extensionsConfig as $value) {
            $this->finder->name('*.'.$value);
        }
    }
}
