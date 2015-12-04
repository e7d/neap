<?php
namespace User\V1\Rest\User;

class UserResourceFactory
{
    public function __invoke($services)
    {
        return new UserResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('User\Service\UserService')
        );
    }
}
