<?php
namespace Channel\V1\Rest\Channel;

class ChannelResourceFactory
{
    public function __invoke($services)
    {
        return new ChannelResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Channel\Service\ChannelService')
        );
    }
}
