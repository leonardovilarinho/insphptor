<?php

namespace Insphptor\Program\ExportServices;

use Insphptor\Storage\ClassesRepository;
use Insphptor\Program\Helpers\ProgressHelper;
use Webmozart\Json\JsonEncoder;
use Webmozart\Json\JsonDecoder;
use Symfony\Component\Console\Output\OutputInterface;

class JsonExport implements IExport
{
    private $repository;
    private $encoder;
    private $output;
    private $developers;

    public function __construct(ClassesRepository $repository, array $devs, OutputInterface $output)
    {
        $this->repository = $repository;
        $this->encoder = new JsonEncoder();
        $this->out = $output;
        $this->developers = $devs;
    }

    /**
     * Person array for exportation and open and handler json file pushing all new
     * values
     * @param  string|null $path view system export to
     * @param  string|null $alias alias from result generation
     */
    public function export(string $path, float $stars, string $alias = '')
    {
        $json = $this->initializableJson($stars, $alias);

        $step = ($this->repository->count() > 0 ) ? $this->repository->count() : 1;

        $progress = ProgressHelper::start($this->out, 'classes to json', $step);

        $json['classes'] = [];
        foreach (($this->repository)() as $class) {
            $json['classes'][] = $class->toArray();
            $progress->advance();
        }
        $progress->finish();

        $file = 'p'.time().'.json';

        $this->encoder->encodeFile($json, $path . $file);
        $this->saveInfoJson($path, $file);
    }

    private function initializableJson(float $stars, string $alias)
    {
        return [
            'name'  => config()['name'],
            'date'  => date('Y-m-d H:i:s'),
            'alias' => $alias,
            'git'   => HAS_GIT,
            'star'  => $stars,
            'devs'  => $this->developers
        ];
    }

    private function saveInfoJson(string $path, string $file)
    {
        $info = [];
        if (file_exists($path . 'info.json')) {
            $info = (new JsonDecoder)->decodeFile($path . 'info.json');
        }

        $info[] = $file;

        $this->encoder->encodeFile($info, $path . 'info.json');
    }
}
