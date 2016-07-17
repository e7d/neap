<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Ingest;
use Zend\ServiceManager\ServiceManager;

/**
 * IngestModelFactory
 */
class IngestModelFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return IngestModel
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        return new IngestModel(
            $serviceManager->get('Application\Database\Ingest\IngestTableGateway')
        );
    }
}
