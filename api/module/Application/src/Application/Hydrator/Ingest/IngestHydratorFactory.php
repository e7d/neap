<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Ingest;

use Zend\ServiceManager\ServiceManager;

/**
 * IngestHydratorFactory
 */
class IngestHydratorFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return IngestHydrator
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        return new IngestHydrator();
    }
}
