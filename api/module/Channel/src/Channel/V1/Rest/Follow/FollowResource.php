<?php
namespace Channel\V1\Rest\Follow;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class FollowResource extends AbstractResourceListener
{
    private $identityService;
    private $channelService;

    function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->channelService = $channelService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->channelService->fetchFollower($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $paginator = $this->channelService->fetchFollowers($params, true);

        $paginator->setCurrentPageNumber((int) $params['page']);
        $paginator->setItemCountPerPage(25);

        return $paginator;
    }
}
