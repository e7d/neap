<?php
namespace User\V1\Rest\MyUser;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class MyUserResource extends AbstractResourceListener
{
    private $identityService;
    private $userService;

    function __construct($identityService, $userService)
    {
        $this->identityService = $identityService;
        $this->userService = $userService;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        $user = $this->identityService->getIdentity();
        return $this->userService->fetch($user->id);
    }
}
