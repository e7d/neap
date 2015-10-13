<?php

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
