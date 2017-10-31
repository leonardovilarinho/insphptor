<?php
namespace Insphptor\Program\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Insphptor\Storage\ClassesRepository;
use Insphptor\Program\FileManager;
use Insphptor\Program\ResultTable;
use Insphptor\Metrics\DevelopersMetric;
use Insphptor\Metrics\StarsMetric;
use Insphptor\Program\Helpers\BoxObject;
use Insphptor\Program\Config\Config;

/**
 * @codeCoverageIgnore
 */
class RunCommand extends InsphptorCommand
{
    /**
     * Prevent run this program already time
     */
    use LockableTrait;

    /**
     * Configure name and description for this command
     */
    protected function configure()
    {
        $this->setName('run')->setDescription('Run analizer metrics');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initializableCommand($output);

        $fileManager = new FileManager($output);
        $fileManager->storeAllFiles();

        StarsMetric::calculeClassesStars();
        $repository = ClassesRepository::instance();

        $devs = DevelopersMetric::generate($output);

        $stars = StarsMetric::calculeProjectStars();
        BoxObject::display(sprintf('Your project have %1.1f stars', $stars), $output);

        ResultTable::displayMetricsTable($output, $repository);
        ResultTable::displayDevsTable($output, $devs);

        $this->release();
    }

    private function initializableCommand(OutputInterface $output)
    {
        $output->writeln(APP_NAME);
        if (!$this->lock()) {
            throw new \Exception('The command is already running in another process');
        }

        if (!file_exists(config()['project'])) {
            throw new \Exception('Your project not found');
        }
    }
}
