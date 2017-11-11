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
class CleanCommand extends InsphptorCommand
{
    protected function configure()
    {
        $this->setName('clean')
        ->addArgument('view', InputArgument::OPTIONAL, 'The view system to clean data', 'overview')
        ->setDescription('Clean data generate from system view');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        define('IS_GLOBAL', true);
        $view = $input->getArgument('view');
        $path = $this->pathToView($view);

        array_map(function ($file) use ($output) {
            $output->writeln('<fg=blue>Removing</> '.$file.' file.');
            unlink($file);
        }, glob($path.'/data/*.json'));

        $output->writeln('<bg=blue;fg=white>Cache empty.</>');
    }
}
