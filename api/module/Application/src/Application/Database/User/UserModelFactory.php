<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\User;

class UserModelFactory
{
    public function __invoke($services)
    {
        return new UserModel(
            $services->get('Application\Database\User\UserTableGateway')
        );
    }
}
