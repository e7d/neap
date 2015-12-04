<?php
namespace Channel\V1\Rest\MyChannel;

class MyChannelResourceFactory
{
    public function __invoke($services)
    {
        return new MyChannelResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Channel\V1\Service\ChannelService')
        );
    }
}
