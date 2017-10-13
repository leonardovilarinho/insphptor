<?php
namespace Insphptor\Analyzer;

use Insphptor\Storage\ClassesRepository;
use Insphptor\Storage\ComponentsRepository;
use Insphptor\Storage\SourceMetricsRepository;
use Insphptor\Storage\SocialMetricsRepository;
use Insphptor\Metrics\StarsMetric;
use Insphptor\Patterns\Singleton;
use Insphptor\Patterns\Repository;
use Insphptor\Program\Helpers\ProgressHelper;
use Symfony\Component\Console\Output\OutputInterface;

class GeneralAnalyzer extends Singleton
{
    public $repository;

    public $out;

    /**
     * This construtor, to register default repository classes
     * @param ClassesRepository $repository classes to analyse
     */
    public function init()
    {
        $this->repository = ClassesRepository::instance();
    }

    public function analyze() : ClassesRepository
    {
        $this->generateComponents();

        $this->calculateMetric('source', new SourceMetricsRepository);

        if (HAS_GIT) {
            $this->calculateMetric('social', new SocialMetricsRepository);
        }

        StarsMetric::calculeClassesStars();

        return $this->repository;
    }

    /**
     * Find and generante all components from all classes this repository
     */
    public function generateComponents()
    {
        $components = new ComponentsRepository;
        $repository = $this->repository;
        $total = $repository->count() * $components->count();

        $progress = ProgressHelper::start($this->out, 'components', $total);

        foreach ($repository() as $class) {
            foreach ($components() as $name => $component) {
                $result = $component::find($class->token);
                $class->pushAttribute($name, $result);
                $progress->advance();
            }

            if (in_array($class->type, config()['hide'])) {
                $repository->removeClass($class);
            }
        }
        $progress->finish();
    }

    private function calculateMetric(string $title, Repository $metrics)
    {

        $repository = $this->repository;
        $total = $repository->count() * $metrics->count();
        $progress = ProgressHelper::start($this->out, $title.' metrics', $total);

        foreach ($repository() as $key => $class) {
            foreach ($metrics() as $name => $metric) {
                $metric::value($class);
                $progress->advance();
            }
        }
    }

    public function setOutput(OutputInterface $output)
    {
        $this->out = $output;
    }

    public function getRepository() : ClassesRepository
    {
        return $this->repository;
    }
}
