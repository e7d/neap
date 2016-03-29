<?php
namespace Channel\V1\Rest\MyChannel;

class MyChannelResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new MyChannelResource(
            $serviceManager->get('Application\Authorization\IdentityService'),
            $serviceManager->get('Channel\V1\Service\ChannelService')
        );
    }
}
