<?php
namespace Outage\V1\Rest\Outage;

class OutageResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new OutageResource(
            $serviceManager->get('Application\Authorization\IdentityService'),
            $serviceManager->get('Outage\V1\Service\OutageService')
        );
    }
}
