<?php
namespace Stream\V1\Rest\Streams;

use Stream\Model\Stream;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;
use ZF\Hal\Link\LinkCollection;
use ZF\Rest\AbstractResourceListener;

class StreamsResource extends AbstractResourceListener
{
    private $identityService;
    private $streamService;
    private $channelService;
    private $userService;

    function __construct($identityService, $streamService, $channelService, $userService)
    {
        $this->identityService = $identityService;
        $this->streamService = $streamService;
        $this->channelService = $channelService;
        $this->userService = $userService;
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

        return $this->fillEntity($stream);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $streams = $this->streamService->fetchAll($params);

        return $this->fillCollection($streams);
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

    private function fillEntity($stream, $fromCollection = false)
    {
        $streamEntity = new Entity($stream, $stream->id);

        $channel = $this->channelService->fetch($stream->channel_id);
        $user = $this->userService->fetch($channel->user_id);

        $streamEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'stream.rest.streams',
                'params' => array(
                    'stream_id' => $stream->id,
                ),
            ),
        )));
        
        if ($fromCollection) {
            $streamEntity->getLinks()->add(Link::factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channels',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            unset($stream->channel_id);
        } else {
            $channelEntity = new Entity($channel, $channel->id);
            $channelEntity->getLinks()->add(Link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'channel.rest.channels',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            $stream->channel = $channelEntity;
            unset($stream->channel_id);
        }

        $streamEntity->getLinks()->add(Link::factory(array(
            'rel' => 'user',
            'route' => array(
                'name' => 'user.rest.users',
                'params' => array(
                    'user_id' => $user->id,
                ),
            ),
        )));
        unset($stream->user_id);

        return $streamEntity;
    }

    private function fillCollection($resultSet)
    {
        $streams = array();

        foreach ($resultSet as $stream) {
            $streams[] = $this->fillEntity($stream, true);
        }

        return $streams;
    }
}
