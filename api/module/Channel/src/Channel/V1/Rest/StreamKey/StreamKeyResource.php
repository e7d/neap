<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Channel\V1\Rest\StreamKey;

use Application\Authorization\OwnerListener;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class StreamKeyResource extends AbstractResourceListener
{
    private $identityService;
    private $channelService;

    function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->channelService = $channelService;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $channel = $this->channelService->fetch($id);
        $identity = $this->identityService->getIdentity();

        if (!$channel) {
            return new ApiProblem(404, 'The channel does not exists.');
        }

        if (!$this->channelService->isOwner($id, $identity->id)) {
            return new ApiProblem(403, 'The channel is not your property.');
        }

        // ToDo: generate a new stream_key

        return true;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }
}
