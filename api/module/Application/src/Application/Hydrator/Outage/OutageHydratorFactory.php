<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Outage;

use Zend\ServiceManager\ServiceManager;

/**
 * OutageHydratorFactory
 */
class OutageHydratorFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return OutageHydrator
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        return new OutageHydrator(
            $serviceManager->get('Application\Database\Ingest\IngestModel')
        );
    }
}
