<?php
namespace Stream\Service;

class StreamServiceFactory
{
    public function __invoke($services)
    {
        return new StreamService(
            $services->get('Stream\Service\StreamTableGateway'),
            $services->get('Channel\Service\ChannelService'),
            $services->get('User\Service\UserService')
        );
    }
}
