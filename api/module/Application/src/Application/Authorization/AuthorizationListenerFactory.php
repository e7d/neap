<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Authorization;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * AuthorizationListenerFactory
 */
class AuthorizationListenerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return AuthorizationListener
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $authorizationListener = new AuthorizationListener();
        $authorizationListener->setServiceManager($serviceManager);

        return $authorizationListener;
    }
}
