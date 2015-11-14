<?php
namespace User\V1\Rest\Mod;

class ModResourceFactory
{
    public function __invoke($services)
    {
        return new ModResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('User\V1\Service\UserService')
        );
    }
}
