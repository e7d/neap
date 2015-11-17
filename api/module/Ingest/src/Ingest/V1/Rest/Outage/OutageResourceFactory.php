<?php
namespace Ingest\V1\Rest\Outage;

class OutageResourceFactory
{
    public function __invoke($services)
    {
        return new OutageResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Ingest\V1\Service\IngestService')
        );
    }
}
