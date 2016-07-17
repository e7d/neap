<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Authorization;

use ZF\ApiProblem\ApiProblem;

/**
 * Handles resource related authorization
 *
 * Defines a authorization based service used to check user ownership over resource related entites.
 */
trait AuthorizationAwareResourceTrait
{
    /**
     * Internal identity service for user retrieval
     *
     * @var IdentityService
     */
    protected $identityService;

    /**
     * Returns the identity service
     *
     * @return IdentityService
     */
    public function getIdentityService()
    {
        return $this->identityService;
    }

    /**
     * Checks user's ownership on the requested resource.
     *
     * @param string $entityId
     *
     * @return ApiProblem|true
     */
    public function userIsOwner(string $entityId)
    {
        if (!$this->getService()) {
            return new ApiProblem(500, 'This resource does not expose a valid service');
        }

        if (!method_exists($this->getService(), 'isOwner')) {
            return new ApiProblem(500, 'This resource service does not expose an owner validation method');
        }

        $user = $this->getIdentityService()->getIdentity();
        if (is_null($user)) {
            return new ApiProblem(401, 'This resource service requires a logged in user');
        }

        if (!$this->getService()->isOwner($entityId, $user->user_id)) {
            return new ApiProblem(403, 'The entity is not your property');
        }

        return true;
    }
}
