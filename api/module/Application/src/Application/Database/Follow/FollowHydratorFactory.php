<?php
namespace Application\Database\Follow;

class FollowHydratorFactory
{
    public function __invoke($services)
    {
        return new FollowHydrator(
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
