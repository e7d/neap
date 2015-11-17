<?php
namespace Channel\V1\Rest\MyChannel;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class MyChannelResource extends AbstractResourceListener
{
    private $identityService;
    private $channelService;

    function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->channelService = $channelService;
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
        return $this->channelService->fetchByUser($user->id);
    }
}
