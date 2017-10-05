<?php

namespace Insphptor\Storage;

use Insphptor\Patterns\Repository;

class SocialMetricsRepository extends Repository
{
    /**
     * Define source metric for finded in any class
     */
    public function create()
    {
        $this->items = [
            \Insphptor\Metrics\SocialMetrics\BugMetric::class,
            \Insphptor\Metrics\SocialMetrics\InstabilityMetric::class,
        ];
    }
}
