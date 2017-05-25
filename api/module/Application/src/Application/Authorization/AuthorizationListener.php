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

use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\MvcAuth\MvcAuthEvent;

/**
 * Sets the identity of the connected user, if any
 */
class AuthorizationListener
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;

    /**
     * @param ServiceLocatorInterface $serviceManager
     *
     * @return self
     */
    public function setServiceManager(ServiceLocatorInterface $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * Listens to the invokation of the Event Authorization event.
     *
     * @param MvcAuthEvent $mvcAuthEvent
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = $mvcAuthEvent->getIdentity()->getAuthenticationIdentity();

        if (!is_null($identity)) {
            $user = $this->serviceManager
                ->get('Application\Database\User\UserModel')
                ->fetch($identity['user_id']);
            $this->serviceManager
                ->get('Application\Authorization\IdentityService')
                ->setIdentity($user);
        }
    }
}
