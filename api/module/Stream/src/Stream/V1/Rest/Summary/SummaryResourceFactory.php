<?php
namespace Stream\V1\Rest\Summary;

class SummaryResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new SummaryResource(
            $serviceManager->get('Application\Authorization\IdentityService'),
            $serviceManager->get('Stream\V1\Service\StreamService')
        );
    }
}
