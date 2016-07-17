<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Authorization;

use Application\Database\User\User;

/**
 * Holds the identity of the authenticated user
 */
class IdentityService
{
    /**
     * The identified user
     *
     * @var User
     */
    protected $identity;

    /**
     * @param User $identity
     *
     * @return self
     */
    public function setIdentity(User $identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * @return User
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
