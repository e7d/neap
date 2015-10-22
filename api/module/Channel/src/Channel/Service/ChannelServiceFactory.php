<?php
namespace Channel\Service;

class ChannelServiceFactory
{
    public function __invoke($services)
    {
        return new ChannelService(
            $services->get('Channel\Service\ChannelHydratorService'),
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
