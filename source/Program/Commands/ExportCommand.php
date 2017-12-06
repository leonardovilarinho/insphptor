<?php
namespace Insphptor\Program\Commands;

use Insphptor\Program\ExportServices\JsonExport;
use Insphptor\Metrics\DevelopersMetric;
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
class ExportCommand extends InsphptorCommand
{
    protected function configure()
    {
        $this->setName('run:export')
        ->addArgument('view', InputArgument::OPTIONAL, 'The view system', 'overview')
        ->addOption('open', 'o', InputOption::VALUE_NONE, 'Open server with result in view')
        ->addOption('flag', 'f', InputOption::VALUE_NONE, 'Alias from this generation')
        ->setDescription('Export result in export file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $view = $input->getArgument('view');
        $this->call('run', $output);

        if (!isset(config()['views'][$view])) {
            throw new \Exception(sprintf('View "%s" not found', $view));
        }

        $flag = '';
        if ($input->getOption('flag')) {
            $flag = $this->askNameFromGeneration($input, $output);
        }
        $devs = DevelopersMetric::getDevelopers();
        $path = $this->pathToView($view);

        $export = new JsonExport(ClassesRepository::instance(), $devs, $output);
        $export->export($path.'/data/', $flag == null ? '' : $flag);

        BoxObject::display('The result was exported!', $output);

        if ($input->getOption('open')) {
            $this->call('start', $output);
        }
    }

    private function askNameFromGeneration(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question(
            'What is the nickname of this generation? Default is <fg=blue>null</>'.EOL.'> ',
            null
        );

        return $helper->ask($input, $output, $question);
    }
}
