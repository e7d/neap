<?php
namespace Channel\V1\Rest\Follow;

class FollowResourceFactory
{
    public function __invoke($services)
    {
        return new FollowResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Channel\Service\ChannelService')
        );
    }
}
