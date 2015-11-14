<?php
namespace Topic\V1\Rest\Top;

class TopResourceFactory
{
    public function __invoke($services)
    {
        return new TopResource();
    }
}
