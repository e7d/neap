<?php
namespace Application\Database\User;

class UserModelFactory
{
    public function __invoke($services)
    {
        return new UserModel(
            $services->get('Application\Database\User\UserTableGateway')
        );
    }
}
