<?php
namespace Stream\V1\Rest\Streams;

class StreamsResourceFactory
{
    public function __invoke($services)
    {
        return new StreamsResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Stream\Service\StreamService'),
            $services->get('Channel\Service\ChannelService'),
            $services->get('User\Service\UserService')
        );
    }
}
