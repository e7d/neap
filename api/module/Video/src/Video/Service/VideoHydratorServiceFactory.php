<?php
namespace Video\Service;

class VideoHydratorServiceFactory
{
    public function __invoke($services)
    {
        return new VideoHydratorService(
            $services->get('Application\Database\Stream\StreamModel'),
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
