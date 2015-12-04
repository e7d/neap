<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Ingest\V1\Rest\Ingest;

class IngestResourceFactory
{
    public function __invoke($services)
    {
        return new IngestResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Ingest\V1\Service\IngestService')
        );
    }
}
