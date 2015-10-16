<?php
namespace Stream\V1\Rest\Stream;

class StreamResourceFactory
{
    public function __invoke($services)
    {
        return new StreamResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Stream\Service\StreamService'),
            $services->get('Channel\Service\ChannelService')
        );
    }
}
