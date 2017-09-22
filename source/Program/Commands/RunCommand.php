<?php

namespace Insphptor\Program\Commands;

use Webmozart\Console\Api\Args\Args;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Storage\ClassesRepository;
use Insphptor\Analyzer\GeneralAnalyzer;
use Symfony\Component\Finder\Finder;

class RunCommand extends Command
{
    /**
     * Storage GeneralAnalyzer
     * @var Insphptor\Analyzer\GeneralAnalyzer
     */
    private $ga;

    /**
     * Get settings and files applying the config definitions, after store all classes
     * in repository of classes, in end use GeneralAnalyzer to generate components
     * and calculate all metrics
     * @param  Args   $args arguments for command
     * @return int       output to detection of errors
     */
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

        $this->ga = new GeneralAnalyzer(ClassesRepository::instance());
        $this->ga->generateComponents();
        $this->ga->calculateSourceMetrics();
        $this->ga->showAllClasses();

        return 0;
    }

    /**
     * Export command, call run command and get result for generate json file
     * @param  Args   $args command arguments: view - define displayed system; open - init server php
     * @return int       output from command
     */
    public function export(Args $args) : int
    {
        $this->handle($args);
        echo 'Loading json...' . EOL;

        $this->ga->generateJson($args->getArgument('view'));

        if ($args->getOption('open')) {
            $view = $args->getArgument('view');
            $p = config()['views'][  $view ];
            $p .= substr(config()['views'][$view], 0, -1) == '/' ? '' : '/';

            $path = config()['project'] . '/' . $p;
            echo color('Serving the result in http://localhost:8000')->bold;
            exec('php -S 0.0.0.0:8000 -t ' . $path);
        }

        return 0;
    }
}
