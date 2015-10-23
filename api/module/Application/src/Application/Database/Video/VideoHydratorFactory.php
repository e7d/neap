<?php
namespace Application\Database\Video;

class VideoHydratorFactory
{
    public function __invoke($services)
    {
        return new VideoHydrator(
            $services->get('Application\Database\Stream\StreamModel'),
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
