<?php

namespace Arquivei\Prometheus\Count;

use Arquivei\Prometheus\Metrics;
use Prometheus\Exception\MetricNotFoundException;

class HistogramMetric extends Metrics
{
    public function __construct(?string $metric, ?string $hint)
    {
        $this->metric = strtolower(preg_replace('/(?<!^)([a-z])([A-Z])/', '$1_$2', $metric));
        $this->hint = $hint;
        parent::getPrometheusInstance();
    }

    public function getMetric(): ?string
    {
        return $this->metric;
    }

    public function setMetric(string $metric): HistogramMetric
    {
        $this->metric = strtolower(preg_replace('/(?<!^)([a-z])([A-Z])/', '$1_$2', $metric));
        return $this;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function setHint(string $hint): HistogramMetric
    {
        $this->hint = $hint;
        return $this;
    }

    public function getObserve()
    {
        return $this->observe;
    }

    public function setObserve($observe)
    {
        $this->observe = $observe;
        return $this;
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
}