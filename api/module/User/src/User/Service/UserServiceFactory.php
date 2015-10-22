<?php
namespace User\Service;

class UserServiceFactory
{
    public function __invoke($services)
    {
        return new UserService(
            $services->get('User\Service\UserHydratorService'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
