<?php
namespace User\V1\Rest\Block;

class BlockResourceFactory
{
    public function __invoke($services)
    {
        return new BlockResource();
    }
}
