<?php
namespace Stream\Service;

class StreamHydratorServiceFactory
{
    public function __invoke($services)
    {
        return new StreamHydratorService(
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
