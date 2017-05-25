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
