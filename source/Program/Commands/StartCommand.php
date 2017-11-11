<?php
namespace Insphptor\Program\Commands;

use Insphptor\Program\ExportServices\JsonExport;
use Insphptor\Metrics\DevelopersMetric;
use Insphptor\Metrics\StarsMetric;
use Insphptor\Program\Helpers\BoxObject;
use Insphptor\Storage\ClassesRepository;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
class StartCommand extends InsphptorCommand
{
    protected function configure()
    {
        $this->setName('start')
        ->addArgument('view', InputArgument::OPTIONAL, 'The view system', 'overview')
        ->addOption('port', 'p', InputOption::VALUE_REQUIRED, 'Port to start server')
        ->setDescription('Start an server to view system');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        define('IS_GLOBAL', true);
        $view = $input->getArgument('view');
        $port = $input->getOption('port');
        $port = $port != null ? $port : 8000;

        $path = $this->pathToView($view);
        $output->writeln('Serving the result in <bg=blue;fg=white>http://localhost:'.$port.'</>');
        exec('php -S 0.0.0.0:'.$port.' -t ' . $path);
    }
}
