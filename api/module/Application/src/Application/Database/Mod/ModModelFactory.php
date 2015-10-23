<?php
namespace Application\Database\Mod;

class ModModelFactory
{
    public function __invoke($services)
    {
        return new ModModel(
            $services->get('Application\Database\Mod\ModTableGateway')
        );
    }
}
