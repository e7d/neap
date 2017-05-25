<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
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
