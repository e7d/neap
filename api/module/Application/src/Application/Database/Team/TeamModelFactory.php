<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Team;
use Zend\ServiceManager\ServiceManager;

/**
 * TeamModelFactory
 */
class TeamModelFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return TeamModel
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        return new TeamModel(
            $serviceManager->get('Application\Database\Team\TeamTableGateway')
        );
    }
}
