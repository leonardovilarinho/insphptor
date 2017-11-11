<?php

namespace Insphptor\Storage;

use Insphptor\Patterns\Repository;

class SourceMetricsRepository extends Repository
{
    /**
     * Define source metric for finded in any class
     */
    public function create()
    {
        $this->items = [
            'size'          =>  \Insphptor\Metrics\SourceMetrics\SizeMetric::class,
            'complexity'    =>  \Insphptor\Metrics\SourceMetrics\ComplexityMetric::class,
            'efferent'      =>  \Insphptor\Metrics\SourceMetrics\EfferentMetric::class,
            'afferent'      =>  \Insphptor\Metrics\SourceMetrics\AfferentMetric::class,
            'cohesion'      =>  \Insphptor\Metrics\SourceMetrics\CohesionMetric::class,
        ];
    }
}
