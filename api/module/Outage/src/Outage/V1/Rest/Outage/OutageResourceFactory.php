<?php
namespace Outage\V1\Rest\Outage;

class OutageResourceFactory
{
    public function __invoke($services)
    {
        return new OutageResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Outage\V1\Service\OutageService')
        );
    }
}
