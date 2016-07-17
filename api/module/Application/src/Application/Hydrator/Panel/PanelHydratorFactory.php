<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Panel;

use Zend\ServiceManager\ServiceManager;

/**
 * PanelHydratorFactory
 */
class PanelHydratorFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return PanelHydrator
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        return new PanelHydrator(
            $serviceManager->get('Application\Database\Channel\ChannelModel')
        );
    }
}
