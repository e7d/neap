<?php
namespace Stream\Service;

class StreamServiceFactory
{
    public function __invoke($services)
    {
        return new StreamService(
            $services->get('Stream\Service\StreamHydratorService'),
            $services->get('Application\Database\Stream\StreamModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
