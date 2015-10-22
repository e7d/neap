<?php
namespace User\Service;

class UserHydratorServiceFactory
{
    public function __invoke($services)
    {
        return new UserHydratorService(
            $services->get('Application\Database\User\UserModel'),
            $services->get('Application\Database\Channel\ChannelModel')
        );
    }
}
