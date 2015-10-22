<?php
namespace Panel\V1\Rest\Panel;

class PanelResourceFactory
{
    public function __invoke($services)
    {
        return new PanelResource();
    }
}
