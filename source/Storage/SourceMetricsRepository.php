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
            \Insphptor\Metrics\SourceMetrics\SizeMetric::class,
            \Insphptor\Metrics\SourceMetrics\ComplexityMetric::class,
            //\Insphptor\Metrics\SourceMetrics\EncapsulationMetric::class,
            \Insphptor\Metrics\SourceMetrics\EfferentMetric::class,
            \Insphptor\Metrics\SourceMetrics\AfferentMetric::class,
            \Insphptor\Metrics\SourceMetrics\CohesionMetric::class,
        ];
    }
}
