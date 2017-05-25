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

namespace Application\Console;

use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\AbstractConsoleController as ZendAbstractConsoleController;

/**
 * Manages the console execution of the application
 */
class AbstractConsoleController
    extends ZendAbstractConsoleController
    implements ServiceLocatorAwareInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceManager;

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function getConfig(string $key = null)
    {
        if (is_null($key)) {
            return $this->config;
        }

        return $this->config[$key];
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceManager;
    }

    /**
     * @param ServiceLocatorInterface $serviceManager
     *
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceManager)
    {
        if ($serviceManager instanceof ControllerManager) {
            $this->serviceManager = $serviceManager;
            $this->config = $serviceManager->getServiceLocator()->get('config');
        }
        return $this;
    }
}
