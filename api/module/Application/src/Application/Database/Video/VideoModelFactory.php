<?php
namespace Application\Database\Video;

class VideoModelFactory
{
    public function __invoke($services)
    {
        return new VideoModel(
            $services->get('Application\Database\Video\VideoTableGateway')
        );
    }
}
