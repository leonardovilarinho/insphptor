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

        $stars = StarsMetric::calculeProjectStars();
        $devs = DevelopersMetric::getDevelopers();
        $path = $this->pathToView($view);

        $export = new JsonExport(ClassesRepository::instance(), $devs, $output);
        $export->export($path.'/data/', $stars, $flag);

        BoxObject::display(sprintf('The result was exported to %s/data', $path), $output);

        if ($input->getOption('open')) {
            $output->writeln('Serving the result in <bg=blue;fg=white>http://localhost:8000</>');
            exec('php -S 0.0.0.0:8000 -t ' . $path);
        }
    }

    private function pathToView(string $view) : string
    {
        $view = config()['views'][$view];
        $isLocal = false;
        if ($view == 'insphptor-overview') {
            $isLocal = true;
            $view = __DIR__.'/../../../views/overview';
        }

        $view .= substr($view, 0, -1) == '/' ? '' : '/';

        return ($isLocal ? '' : config()['project']) . $view;
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
