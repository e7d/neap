<?php
namespace Application\Database\User;

class UserHydratorFactory
{
    public function __invoke($services)
    {
        return new UserHydrator(
            $services->get('Application\Database\User\UserModel'),
            $services->get('Application\Database\Channel\ChannelModel')
        );
    }
}
