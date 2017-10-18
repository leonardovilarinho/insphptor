<?php

namespace Insphptor\Program;

use Symfony\Component\Console\Output\OutputInterface;
use Insphptor\Analyzer\AnalyzedClass;
use Insphptor\Storage\ClassesRepository;
use Insphptor\Program\Helpers\ProgressHelper;

/**
 * @codeCoverageIgnore
 */
class FileManager
{
    private $output;
    private $repository;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        $this->repository = ClassesRepository::instance();
    }

    public function storeAllFiles()
    {
        $files = (new FinderFiles)->getFiles();

        $progress = ProgressHelper::start($this->output, 'files', count($files));

        foreach ($files as $file) {
            $this->repository->pushClass(new AnalyzedClass($file->getRealPath()));
            $progress->advance();
        }

        $progress->finish();
        unset($files, $progress, $repository);
    }
}
