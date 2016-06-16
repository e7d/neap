<?php
namespace Ingest\V1\Rest\Outage;

class OutageResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new OutageResource(
            $serviceManager->get('Application\Authorization\IdentityService'),
            $serviceManager->get('Ingest\V1\Service\IngestService')
        );
    }
}
