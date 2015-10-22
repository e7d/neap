<?php
namespace Video\V1\Rest\Video;

class VideoResourceFactory
{
    public function __invoke($services)
    {
        return new VideoResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Video\Service\VideoService')
        );
    }
}
