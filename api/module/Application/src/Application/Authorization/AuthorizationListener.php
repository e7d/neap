<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Authorization;

use ZF\MvcAuth\MvcAuthEvent;

class AuthorizationListener
{
    protected $serviceManager;

    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * [__invoke description]
     * @param  MvcAuthEvent $mvcAuthEvent [description]
     * @return [type]                     [description]
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
