<?php

namespace Arquivei\Prometheus;

interface PrometheusMetricsInterface
{
    public function count(int $count = 1);
    public function observe();
}
