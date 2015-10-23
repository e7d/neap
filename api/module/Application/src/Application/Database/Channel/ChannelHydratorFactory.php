<?php
namespace Application\Database\Channel;

class ChannelHydratorFactory
{
    public function __invoke($services)
    {
        return new ChannelHydrator(
            $services->get('Application\Database\Chat\ChatModel'),
            $services->get('Application\Database\Stream\StreamModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
