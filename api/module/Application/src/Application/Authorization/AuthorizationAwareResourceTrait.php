<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Authorization;

use ZF\ApiProblem\ApiProblem;

trait AuthorizationAwareResourceTrait {
    private $service;

    /**
     * Checks user's rights on requested resource
     *
     * @param  mixed $id
     * @return ApiProblem|true
     */
    public function userIsOwner($id)
    {
        if (!$this->service) {
            return new ApiProblem(500, 'This resource does not expose a valid service');
        }

        $entity = $this->service->fetch($id);
        if (!$entity) {
            return new ApiProblem(404, 'The entity does not exists');
        }

        if (!method_exists($this->service, 'isOwner'))
        {
            return new ApiProblem(500, 'This resource service does not expose a owner validation method');
        }

        $identity = $this->identityService->getIdentity();
        if (!$this->service->isOwner($id, $identity->id)) {
            return new ApiProblem(403, 'The entity is not your property');
        }

        return true;
    }
}
