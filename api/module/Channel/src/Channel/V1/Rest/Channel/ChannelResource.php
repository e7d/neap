<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Channel\V1\Rest\Channel;

use Application\Authorization\AuthorizationAwareResourceTrait;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class ChannelResource extends AbstractResourceListener
{
    use AuthorizationAwareResourceTrait;

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
        return $this->channelService->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        return $this->channelService->fetchAll($params);
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $userIsOwner = $this->userIsOwner($id);
        if ($userIsOwner instanceof ApiProblem) {
            return $userIsOwner;
        }

        return $this->channelService->update($id, (array) $data);
    }
}
