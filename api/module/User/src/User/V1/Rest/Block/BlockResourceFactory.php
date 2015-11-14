<?php
namespace User\V1\Rest\Block;

class BlockResourceFactory
{
    public function __invoke($services)
    {
        return new BlockResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('User\V1\Service\UserService')
        );
    }
}
