<?php
namespace Stream\V1\Rest\Stream;

use ZF\ApiProblem\ApiProblem;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;
use ZF\Hal\Link\LinkCollection;
use ZF\Rest\AbstractResourceListener;

class StreamResource extends AbstractResourceListener
{
    private $identityService;
    private $streamService;
    private $channelService;

    function __construct($identityService, $streamService, $channelService)
    {
        $this->identityService = $identityService;
        $this->streamService = $streamService;
        $this->channelService = $channelService;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $stream = $this->streamService->fetch($id);
        $streamOwner = $this->streamService->fetchOwner($id);

        if (!$stream) {
            $entity = new Entity(array(), $id);
        } else {
            if ($streamOwner) {
                $channel = $this->channelService->fetch($streamOwner->channel_id);
                $stream->channel = $channel;
                unset($stream->channel_id);
            }

            $entity = new Entity($stream, $id);
        }

        if ($streamOwner) {
            $channelLink = new Link("channel");
            $channelLink->setUrl("/channel/".$streamOwner->channel_id);
            $entity->getLinks()->add($channelLink);

            $userLink = new Link("user");
            $userLink->setUrl("/user/".$streamOwner->user_id);
            $entity->getLinks()->add($userLink);
        }

        return $entity;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        return $this->streamService->fetchAll($params);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
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
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
