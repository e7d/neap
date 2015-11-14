<?php
namespace Stream\V1\Rest\Summary;

class SummaryResourceFactory
{
    public function __invoke($services)
    {
        return new SummaryResource();
    }
}
