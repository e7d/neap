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
    private $serviceManager;

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
        return $this->serviceManager;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceManager)
    {
        if ($serviceManager instanceof \Zend\Mvc\Controller\ControllerManager) {
            $this->serviceManager = $serviceManager;
            $this->config = $serviceManager->getServiceLocator()->get('config');
        }
        return $this;
    }
}
