<?php
namespace Application\Database\Panel;

class PanelModelFactory
{
    public function __invoke($services)
    {
        return new PanelModel(
            $services->get('Application\Database\Panel\PanelTableGateway')
        );
    }
}
