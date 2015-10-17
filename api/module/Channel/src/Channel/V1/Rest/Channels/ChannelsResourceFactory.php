<?php
namespace Channel\V1\Rest\Channels;

class ChannelsResourceFactory
{
    public function __invoke($services)
    {
        return new ChannelsResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Channel\Service\ChannelService')
        );
    }
}
