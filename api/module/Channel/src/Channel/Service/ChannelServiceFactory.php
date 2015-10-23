<?php
namespace Channel\Service;

class ChannelServiceFactory
{
    public function __invoke($services)
    {
        return new ChannelService(
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\Channel\ChannelHydrator'),
            $services->get('Application\Database\Follow\FollowModel'),
            $services->get('Application\Database\Follow\FollowHydrator'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
