<?php
namespace Application\Database\Block;

class BlockModelFactory
{
    public function __invoke($services)
    {
        return new BlockModel(
            $services->get('Application\Database\Block\BlockTableGateway')
        );
    }
}
