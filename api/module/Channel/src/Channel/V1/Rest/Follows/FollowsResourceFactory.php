<?php
namespace Channel\V1\Rest\Follows;

class FollowsResourceFactory
{
    public function __invoke($services)
    {
        return new FollowsResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Channel\Service\ChannelService')
        );
    }
}
