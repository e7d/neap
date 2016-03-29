<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
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

    public function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->channelService = $channelService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $channelId
     * @return ApiProblem|mixed
     */
    public function fetch($channelId)
    {
        return $this->channelService->fetch($channelId);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->channelService->fetchAll($params);
    }

    /**
     * Update a resource
     *
     * @param  mixed $channelId
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($channelId, $data)
    {
        $this->service = $this->channelService;
        $userIsOwner = $this->userIsOwner($channelId);
        if ($userIsOwner instanceof ApiProblem) {
            return $userIsOwner;
        }

        return $this->channelService->update($channelId, (array) $data);
    }
}
