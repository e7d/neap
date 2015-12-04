<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Outage\V1\Service;

class OutageServiceFactory
{
    public function __invoke($services)
    {
        return new OutageService(
            $services->get('Application\Database\Outage\OutageModel'),
            $services->get('Application\Hydrator\Outage\OutageHydrator')
        );
    }
}
