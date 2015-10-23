<?php
namespace User\Service;

class UserServiceFactory
{
    public function __invoke($services)
    {
        return new UserService(
            $services->get('Application\Database\User\UserModel'),
            $services->get('Application\Database\User\UserHydrator')
        );
    }
}
