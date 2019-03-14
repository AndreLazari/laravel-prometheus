<?php

namespace Arquivei\Prometheus\Count;

use Arquivei\Prometheus\Metrics;
use Prometheus\Exception\MetricNotFoundException;

class CountMetric extends Metrics
{
    public function __construct(?string $metric, ?string $hint)
    {
        $this->metric = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $metric));
        $this->hint = $hint;
        parent::getPrometheusInstance();
    }

    public function getMetric(): ?string
    {
        return $this->metric;
    }

    public function setMetric(string $metric): CountMetric
    {
        $this->metric = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $metric));
        return $this;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function setHint(string $hint): CountMetric
    {
        $this->hint = $hint;
        return $this;
    }

    public function count(int $count = 1)
    {
        try {
            $counter = $this->prometheus->getCounter($this->metric);
            $counter->incBy($count);
        } catch (MetricNotFoundException $metricNotFoundException) {
            $this->registerCounter();
            $this->count($count);
        }
    }


}