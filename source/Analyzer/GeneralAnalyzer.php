<?php
namespace Insphptor\Analyzer;

use Insphptor\Storage\ClassesRepository;
use Insphptor\Storage\ComponentsRepository;
use Insphptor\Storage\SourceMetricsRepository;
use Webmozart\Json\JsonEncoder;
use Webmozart\Json\JsonDecoder;

class GeneralAnalyzer
{
    /**
     * Repository of classes, to calculate this
     * @var Insphptor\Storage\ComponentsRepository
     */
    private $repository;

    /**
     * This construtor, to register default repository classes
     * @param ClassesRepository $repository classes to analyse
     */
    public function __construct(ClassesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find and generante all components from all classes this repository
     */
    public function generateComponents()
    {
        $components = new ComponentsRepository;
        $repository = $this->repository;

        foreach ($repository() as $class) {
            foreach ($components() as $name => $component) {
                $result = $component::find($class->token);
                $class->pushAttribute($name, $result);
            }
        }
    }

    /**
     * Calculate and save all source metrics in every class from this repositorie
     */
    public function calculateSourceMetrics()
    {
        $metrics = new SourceMetricsRepository;
        $repository = $this->repository;

        foreach ($repository() as &$class) {
            foreach ($metrics() as $name => $metric) {
                $metric::value($class);
            }
        }
    }

    /**
     * Show all classes details
     */
    public function showAllClasses()
    {
        $repository = $this->repository;

        foreach ($repository() as $class) {
            $class->print();
        }
    }

    /**
     * Person array for exportation and open and handler json file pushing all new
     * values
     * @param  string|null $view view system export to
     */
    public function generateJson(string $view = null)
    {
        $repository = $this->repository;
        $json = [
            'name' => config()['name'],
            'date' => date('Y-m-d H:i:s'),
            'star' => 3
        ];

        foreach ($repository() as $class) {
            $json['classes'][] = $class->toArray() + ['star' => 2.5];
        }

        if (!isset(config()['views'][$view])) {
            die(color('View not found!')->bg_red);
        }

        $encoder = new JsonEncoder();

        $p = config()['views'][$view];
        $p .= substr(config()['views'][$view], 0, -1) == '/' ? '' : '/';

        $path = config()['project'] . '/' . $p . 'data/';
        $file = 'p'.time().'.json';

        $encoder->encodeFile($json, $path . $file);

        $info = [];
        if (file_exists($path . 'info.json')) {
            $info = (new JsonDecoder)->decodeFile($path . 'info.json');
        }

        $info[] = $file;

        $encoder->encodeFile($info, $path . 'info.json');
    }
}
