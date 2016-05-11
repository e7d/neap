<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace User\V1\Rest\User;

use Application\Rest\AbstractResourceListener;
use ZF\ApiProblem\ApiProblem;

class UserResource extends AbstractResourceListener
{
    public function __construct($identityService, $userService)
    {
        $this->identityService = $identityService;
        $this->service = $userService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $userId
     * @return ApiProblem|mixed
     */
    public function fetch($userId)
    {
        return $this->service->fetch($userId);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->service->fetchAll($params);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $userId
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($userId, $data)
    {
        $userIsOwner = $this->userIsOwner($userId);
        if ($userIsOwner instanceof ApiProblem) {
            return $userIsOwner;
        }

        return $this->service->update($userId, $data);
    }

    /**
     * Update a resource
     *
     * @param  mixed $userId
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($userId, $data)
    {
        $userIsOwner = $this->userIsOwner($userId);
        if ($userIsOwner instanceof ApiProblem) {
            return $userIsOwner;
        }

        return $this->service->update($userId, $data);
    }
}
