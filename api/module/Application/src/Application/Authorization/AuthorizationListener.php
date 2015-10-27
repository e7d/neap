<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Authorization;

use ZF\MvcAuth\MvcAuthEvent;

class AuthorizationListener
{
    protected $services;

    public function setServiceManager($services)
    {
        $this->services = $services;
    }

    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = $mvcAuthEvent->getIdentity()->getAuthenticationIdentity();

        if (!is_null($identity)) {
            $identity = $this->services
                ->get('User\Service\UserService')
                ->fetch($identity['user_id']);
            $this->services
                ->get('Application\Authorization\IdentityService')
                ->setIdentity($identity);
        }
    }
}
