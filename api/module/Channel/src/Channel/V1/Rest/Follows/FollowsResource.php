<?php
namespace Channel\V1\Rest\Follows;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class FollowsResource extends AbstractResourceListener
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
        return $this->channelService->fetchFollowers($id);
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
