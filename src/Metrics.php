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

    protected function registerCounter()
    {
        $this->prometheus->registerCounter($this->metric, $this->hint);
    }

    protected function registerHistogram()
    {
        $this->prometheus->registerHistogram($this->histogram, $this->hint);
    }
}