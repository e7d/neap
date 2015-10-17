<?php
namespace User\V1\Rest\Users;

class UsersResourceFactory
{
    public function __invoke($services)
    {
        return new UsersResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('User\Service\UserService')
        );
    }
}
