<?php

namespace Application\Authorization;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthorizationListenerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $authorizationListener = new AuthorizationListener();
        $authorizationListener->setServiceManager($services);

        return $authorizationListener;
    }
}
