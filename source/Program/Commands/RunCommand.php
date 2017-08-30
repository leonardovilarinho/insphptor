<?php

namespace Insphptor\Program\Commands;

use Webmozart\Console\Api\Args\Args;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Storage\ClassesRepository;
use Insphptor\Analyzer\GeneralAnalyzer;
use Symfony\Component\Finder\Finder;

class RunCommand extends Command
{
    public function handle(Args $args) : int
    {
        $this->showSplashScreen();
        echo 'Loading files...' . EOL;

        if (! file_exists(config()['project'])) {
            return 1;
        }

        $finder = new Finder;
        $finder->files()->in(config()['project']);

        foreach (config()['ignored'] as $value) {
            $finder->exclude($value);
        }

        foreach (config()['extensions'] as $value) {
            $finder->name('*.'.$value);
        }

        $step = (int)(100 / count($finder));
        $progress = 0;

        foreach ($finder as $file) {
            try {
                ClassesRepository::instance()->pushClass(new AnalyzedClass($file->getRealPath()));
                progress($step, $progress);
            } catch (\Exception $e) {
                echo color($e->getMessage())->red();
            }
        }
        echo ' 100%'.EOL;

        echo EOL . ClassesRepository::instance()->count() . ' classes found!' . EOL;

        $ga = new GeneralAnalyzer(ClassesRepository::instance());
        $ga->generateComponents();
        $ga->showComponents();

        return 0;
    }

    public function export(Args $args) : int
    {
        $this->handle($args);
        $io->writeLine('Loading json...');

        return 0;
    }
}
