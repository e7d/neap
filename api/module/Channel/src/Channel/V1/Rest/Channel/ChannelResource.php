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

namespace Channel\V1\Rest\Channel;

use Application\Rest\AbstractResourceListener;
use ZF\ApiProblem\ApiProblem;

class ChannelResource extends AbstractResourceListener
{
    public function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->service = $channelService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $channelId
     * @return ApiProblem|mixed
     */
    public function fetch($channelId)
    {
        return $this->service->fetch($channelId);
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
     * @param  mixed $channelId
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($channelId, $data)
    {
        $userIsOwner = $this->userIsOwner($channelId);
        if ($userIsOwner instanceof ApiProblem) {
            return $userIsOwner;
        }

        return $this->service->update($channelId, (array) $data);
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
        $userIsOwner = $this->userIsOwner($channelId);
        if ($userIsOwner instanceof ApiProblem) {
            return $userIsOwner;
        }

        return $this->service->update($channelId, $data);
    }
}
