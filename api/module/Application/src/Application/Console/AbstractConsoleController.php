<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Console;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\AbstractConsoleController as ZendAbstractConsoleController;

class AbstractConsoleController extends ZendAbstractConsoleController implements ServiceLocatorAwareInterface
{
    private $config;
    private $services;

    /**
     * @param string $key
     */
    public function getConfig($key = null)
    {
        if (is_null($key)) {
            return $this->config;
        }

        return $this->config[$key];
    }

    public function getServiceLocator()
    {
        return $this->services;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof \Zend\Mvc\Controller\ControllerManager) {
            $this->services = $serviceLocator;
            $this->config = $serviceLocator->getServiceLocator()->get('config');
        }
        return $this;
    }
}
