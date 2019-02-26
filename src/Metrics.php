<?php

namespace Arquivei\Prometheus;

use Prometheus\Exception\MetricNotFoundException;

abstract class Metrics
{
    protected $prometheus;
    protected $metric;
    protected $histogram;
    protected $observe;
    protected $hint;

    protected function getPrometheusInstance()
    {
        $this->prometheus = app('prometheus');
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

    public function observe()
    {
        try {
            $this->prometheus
                ->getHistogram($this->histogram)
                ->observe($this->observe);
        } catch (MetricNotFoundException $metricNotFoundException) {
            $this->registerHistogram();
            $this->observe();
        }
    }

    protected function registerCounter()
    {
        $this->prometheus->registerCounter($this->metric, $this->hint);
    }

    protected function registerHistogram()
    {
        $this->prometheus->registerHistogram($this->histogram, $this->hint);
    }
}