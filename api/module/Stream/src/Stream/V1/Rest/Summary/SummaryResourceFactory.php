<?php
namespace Stream\V1\Rest\Summary;

class SummaryResourceFactory
{
    public function __invoke($services)
    {
        return new SummaryResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Stream\V1\Service\StreamService')
        );
    }
}
