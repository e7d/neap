<?php
namespace Stream\Service;

use Channel\Service\ChannelService;
use Stream\Model\Stream;
use User\Service\UserService;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class StreamHydratorService implements HydratorInterface
{
    protected $params;
    protected $channelService;
    protected $userService;

    public function __construct(ChannelService $channelService, UserService $userService)
    {
        $this->params = array();
        $this->channelService = $channelService;
        $this->userService = $userService;
    }

    public function hydrate(array $data, $stream)
    {
        $stream->exchangeArray($data);
        $streamEntity = $this->buildEntity($stream);
        return $streamEntity;
    }

    public function extract($object)
    {
        return get_object_vars($object);
    }

    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function buildEntity($stream)
    {
        $streamEntity = new Entity($this->extract($stream), $stream->id);

        $channel = $this->channelService->fetch($stream->channel_id);
        $user = $this->userService->fetch($channel->user_id);

        $streamEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'stream.rest.stream',
                'params' => array(
                    'stream_id' => $stream->id,
                ),
            ),
        )));

        if (array_key_exists('isCollection', $this->params) && $this->params['isCollection']) {
            $streamEntity->getLinks()->add(Link::factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channel',
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
                    'name' => 'channel.rest.channel',
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
                'name' => 'user.rest.user',
                'params' => array(
                    'user_id' => $user->id,
                ),
            ),
        )));
        unset($stream->user_id);

        return $streamEntity;
    }
}
