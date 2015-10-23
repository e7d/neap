<?php
namespace Channel\Service;

use Application\Database\Stream\StreamModel;
use Application\Database\Channel\Channel;
use Application\Database\Chat\ChatModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class ChannelHydratorService implements HydratorInterface
{
    protected $params;
    protected $chatModel;
    protected $streamModel;
    protected $userModel;

    public function __construct(ChatModel $chatModel, StreamModel $streamModel, UserModel $userModel)
    {
        $this->params = array();
        $this->chatModel = $chatModel;
        $this->streamModel = $streamModel;
        $this->userModel = $userModel;
    }

    public function hydrate(array $data, $channel)
    {
        $channel->exchangeArray($data);
        $channelEntity = $this->buildEntity($channel);
        return $channelEntity;
    }

    public function extract($object)
    {
        return get_object_vars($object);
    }

    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function buildEntity($channel)
    {
        $user = $this->userModel->fetch($channel->user_id);
        $chat = $this->chatModel->fetch($channel->chat_id);
        $stream = $this->streamModel->fetchLiveStreamByChannel($channel->id);

        $channelEntity = new Entity($this->extract($channel), $channel->id);

        $channelEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'channel.rest.channel',
                'params' => array(
                    'channel_id' => $channel->id,
                ),
            ),
        )));

        $channelEntity->getLinks()->add(Link::factory(array(
            'rel' => 'user',
            'route' => array(
                'name' => 'user.rest.user',
                'params' => array(
                    'user_id' => $user->id,
                ),
            ),
        )));
        unset($channel->user_id);

        $channelEntity->getLinks()->add(Link::factory(array(
            'rel' => 'chat',
            'route' => array(
                'name' => 'chat.rest.chat',
                'params' => array(
                    'chat_id' => $chat->id,
                ),
            ),
        )));
        unset($channel->user_id);

        if (!is_null($stream)) {
            $channelEntity->getLinks()->add(Link::factory(array(
                'rel' => 'stream',
                'route' => array(
                    'name' => 'stream.rest.stream',
                    'params' => array(
                        'stream_id' => $stream->id,
                    ),
                ),
            )));
        }

        return $channelEntity;
    }
}
