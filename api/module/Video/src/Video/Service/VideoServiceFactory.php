<?php
namespace Video\Service;

class VideoServiceFactory
{
    public function __invoke($services)
    {
        return new VideoService(
            $services->get('Video\Service\VideoHydratorService'),
            $services->get('Application\Database\Video\VideoModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
