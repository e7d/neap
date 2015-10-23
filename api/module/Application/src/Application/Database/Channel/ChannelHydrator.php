<?php
namespace Application\Database\Channel;

use Application\Database\Hydrator;
use Application\Database\Chat\ChatModel;
use Application\Database\Stream\StreamModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class ChannelHydrator extends Hydrator
{
    protected $chatModel;
    protected $streamModel;
    protected $userModel;

    public function __construct(ChatModel $chatModel, StreamModel $streamModel, UserModel $userModel)
    {
        $this->chatModel = $chatModel;
        $this->streamModel = $streamModel;
        $this->userModel = $userModel;
    }

    public function buildEntity($channel)
    {
        $user = $this->userModel->fetch($channel->user_id);
        $chat = $this->chatModel->fetch($channel->chat_id);
        $stream = $this->streamModel->fetchLiveStreamByChannel($channel->id);

        if ($this->getParam('embedUser')) {
            $userEntity = new Entity($user, $user->id);
            $userEntity->getLinks()->add(Link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->id,
                    ),
                ),
            )));
            $channel->user = $userEntity;
            unset($channel->user_id);
        }

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

        if (!$this->getParam('embedUser')) {
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
        }

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
