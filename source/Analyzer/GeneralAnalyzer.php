<?php
namespace Insphptor\Analyzer;

use Insphptor\Storage\ClassesRepository;
use Insphptor\Storage\ComponentsRepository;
use Insphptor\Storage\SourceMetricsRepository;
use Insphptor\Helpers\CountStarsHelper;
use Webmozart\Console\Api\IO\IO;
use Webmozart\Console\UI\Component\Table;
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
     * @param  string|null $alias alias from result generation
     */
    public function generateJson(string $view = null, string $alias = null)
    {
        $repository = $this->repository;
        $json = [
            'name'  => config()['name'],
            'date'  => date('Y-m-d H:i:s'),
            'alias' => $alias,
            'star'  => CountStarsHelper::calculeProjectStars()
        ];

        foreach ($repository() as $class) {
            $json['classes'][] = $class->toArray();
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

    public function tableResult(Io $io)
    {
        $repository = $this->repository;
        $table = new Table();
        $table->setHeaderRow(['Type', 'Name', 'Stars']);

        $stars = [];
        foreach ($repository() as $class) {
            $stars[] = $class->star;
        }
        asort($stars);
        $count = 0;
        $stars = \array_chunk($stars, 5)[0];

        $result = [];

        foreach ($repository() as $class) {
            if (in_array($class->star, $stars)) {
                $result[] = $class;
                $key = \array_search($class->star, $stars);
                unset($stars[$key]);
            }
        }

        
        foreach ($result as $class) {
            $table->addRow([
                $class->type,
                $class->namespace . '\\' . $class->name,
                $class->star
            ]);
        }
        
        $table->render($io);
    }
}
