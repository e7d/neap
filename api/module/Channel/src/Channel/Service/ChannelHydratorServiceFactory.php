<?php
namespace Channel\Service;

class ChannelHydratorServiceFactory
{
    public function __invoke($services)
    {
        return new ChannelHydratorService(
            $services->get('Application\Database\Chat\ChatModel'),
            $services->get('Application\Database\Stream\StreamModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
