<?php
namespace Insphptor\Program\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Yaml\Yaml;
use Insphptor\Program\Helpers\BoxObject;

/**
 * @codeCoverageIgnore
 */
class InitCommand extends InsphptorCommand
{
    /**
     * Prevent run this program already time
     */
    use LockableTrait;

    private $yaml = [];
    private $helper;
    private $input;
    private $output;

    /**
     * Configure name and description for this command
     */
    protected function configure()
    {
        $this->setName('init')->setDescription('Wizard to create an insphptor.yml file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        define('IS_GLOBAL', true);
        $this->input = $input;
        $this->output = $output;
        $this->helper = $this->getHelper('question');

        $this->initializableCommand($output);
        BoxObject::display('Wizard to create an insphptor.yml file', $output);

        $path = getcwd();

        $dirs = array_filter(glob($path.'/*'), 'is_dir');
        $dirs = array_map(function ($item) use ($path) {
            return str_replace($path.'/', '', $item);
        }, $dirs);
        rsort($dirs);

        $this->askSimple('What your project name?', $path, 'name');

        $this->askChoice(
            'Select export file type:',
            ['json'],
            'export',
            0,
            'json'
        );

        $this->askChoice(
            'You use Git in project?',
            ['auto', 'yes', 'not'],
            'git',
            0,
            'auto'
        );

        $this->askSimple('How many results should Insphptor show?', '5', 'rank');

        $this->askMultiChoice(
            'Select the file types to ignore:',
            ['interface', 'file', 'class', 'abstract class', 'final class', 'trait'],
            'hide',
            '0,1',
            '0,1'
        );

        $select = $this->askChoice(
            'Do you want to select the folders to be scanned or the folders skipped in the scan?',
            ['only', 'exclude']
        );

        if ($select == 'only') {
            $this->askMultiChoice(
                'Select the folders that Inphptor will scan:',
                $dirs,
                'only',
                -1
            );
        } else {
            $this->askMultiChoice(
                'Select folders that Inphptor will not scan:',
                $dirs,
                'excluded',
                -1
            );
        }


        $this->yaml['views'] = ['overview' => 'insphptor-overview'];

        $yaml = Yaml::dump($this->yaml);

        file_put_contents($path.'/insphptor.yml', $yaml);

        BoxObject::display(sprintf('File saved in %s/insphptor.yml', $path), $output);

        $this->release();
    }

    private function askSimple(string $question, $default, string $name)
    {
        $question = new Question(
            sprintf(EOL.'%s Default is <fg=blue>%s</>'.EOL.' > ', $question, $default),
            $default
        );

        $answer = $this->helper->ask($this->input, $this->output, $question);
        $this->yaml[$name] = $answer;
    }

    private function askChoice(string $question, array $alts, string $name = '', $answer = 0, $default = 'empty')
    {
        $q = new ChoiceQuestion(
            sprintf(EOL.'%s Default is <fg=blue>%s</>', $question, $default),
            $alts,
            $answer
        );
        $q->setErrorMessage('Answer %s is invalid.');

        if ($name == '') {
            return $this->helper->ask($this->input, $this->output, $q);
        }

        $this->yaml[$name] = $this->helper->ask($this->input, $this->output, $q);
    }

    private function askMultiChoice(string $question, array $alts, string $name, $answer, $default = 'empty')
    {
        $q = new ChoiceQuestion(
            sprintf(EOL.'%s Default is <fg=blue>%s</>', $question, $default),
            $alts,
            $answer
        );
        $q->setErrorMessage('Answer %s is invalid.');
        $q->setMultiselect(true);
        $this->yaml[$name] = $this->helper->ask($this->input, $this->output, $q);
    }

    private function initializableCommand(OutputInterface $output)
    {
        $output->writeln(APP_NAME);
        if (!$this->lock()) {
            throw new \Exception('The command is already running in another process');
        }
    }
}
