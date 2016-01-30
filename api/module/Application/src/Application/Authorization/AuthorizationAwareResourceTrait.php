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

trait AuthorizationAwareResourceTrait
{
    private $service;

    /**
     * Checks user's rights on requested resource
     *
     * @param  mixed $entityId
     * @return ApiProblem|true
     */
    public function userIsOwner($entityId)
    {
        if (!$this->service) {
            return new ApiProblem(500, 'This resource does not expose a valid service');
        }

        if (!method_exists($this->service, 'isOwner')) {
            return new ApiProblem(500, 'This resource service does not expose an owner validation method');
        }

        $identity = $this->identityService->getIdentity();
        if (is_null($identity)) {
            return new ApiProblem(401, 'This resource service requires a logged in user');
        }

        if (!$this->service->isOwner($entityId, $identity->user_id)) {
            return new ApiProblem(403, 'The entity is not your property');
        }

        return true;
    }
}
