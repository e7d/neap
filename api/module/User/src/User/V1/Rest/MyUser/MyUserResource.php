<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace User\V1\Rest\MyUser;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class MyUserResource extends AbstractResourceListener
{
    public function __construct($identityService, $userService)
    {
        $this->identityService = $identityService;
        $this->service = $userService;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $user = $this->identityService->getIdentity();
        return $this->service->fetch($user->user_id);
    }
}
