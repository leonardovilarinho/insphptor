<?php

namespace Insphptor\Storage;

use Insphptor\Patterns\Repository;

class SourceMetricsRepository extends Repository
{
    public function create()
    {
        $this->items = [
            'size'          => \Insphptor\Metrics\SourceMetrics\SizeMetric::class,
            'complexity'    => \Insphptor\Metrics\SourceMetrics\ComplexityMetric::class,
            'encapsulation' => \Insphptor\Metrics\SourceMetrics\EncapsulationMetric::class,
            'efferent'      => \Insphptor\Metrics\SourceMetrics\EfferentMetric::class,
        ];
    }
}
