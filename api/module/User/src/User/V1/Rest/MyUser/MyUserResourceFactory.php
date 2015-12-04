<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace User\V1\Rest\MyUser;

class MyUserResourceFactory
{
    public function __invoke($services)
    {
        return new MyUserResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('User\V1\Service\UserService')
        );
    }
}
