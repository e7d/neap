<?php
namespace Channel\V1\Rest\UserChannel;

class UserChannelResourceFactory
{
    public function __invoke($services)
    {
        return new UserChannelResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Channel\Service\ChannelService')
        );
    }
}
