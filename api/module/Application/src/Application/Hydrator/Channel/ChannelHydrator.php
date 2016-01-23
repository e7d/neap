<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Channel;

use Application\Hydrator\Hydrator;
use Application\Database\Chat\ChatModel;
use Application\Database\Stream\StreamModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;

class ChannelHydrator extends Hydrator
{
    protected $chatModel;
    protected $streamModel;
    protected $userModel;

    public function __construct(ChatModel $chatModel, StreamModel $streamModel, UserModel $userModel)
    {
        parent::__construct();
        $this->chatModel = $chatModel;
        $this->streamModel = $streamModel;
        $this->userModel = $userModel;
    }

    public function buildEntity($channel)
    {
        $user = $this->userModel->fetch($channel->user_id);
        $chat = $this->chatModel->fetch($channel->chat_id);
        $liveStream = $this->streamModel->fetchByChannel($channel->channel_id);

        if (!$this->getParam('keepStreamKey')) {
            unset($channel->stream_key);
        }

        if ($this->getParam('embedUser')) {
            $userEntity = new Entity($user, $user->user_id);
            $userEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->user_id,
                    ),
                ),
            )));
            $channel->user = $userEntity;
            unset($channel->user_id);
        }

        if ($this->getParam('embedLiveStream') && !is_null($liveStream)) {
            $liveStreamEntity = new Entity($liveStream, $liveStream->stream_id);
            $liveStreamEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'stream.rest.stream',
                    'params' => array(
                        'stream_id' => $liveStream->stream_id,
                    ),
                ),
            )));
            $channel->stream = $liveStreamEntity;
        }

        $channelEntity = new Entity($this->extract($channel), $channel->channel_id);

        $channelEntity->getLinks()->add($this->link->factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'channel.rest.channel',
                'params' => array(
                    'channel_id' => $channel->channel_id,
                ),
            ),
        )));

        if ($this->getParam('linkUser')) {
            $channelEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'user',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->user_id,
                    ),
                ),
            )));
            unset($channelEntity->entity['user_id']);
        }

        if ($this->getParam('linkLiveStream') && !is_null($liveStream)) {
            $channelEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'stream',
                'route' => array(
                    'name' => 'stream.rest.stream',
                    'params' => array(
                        'stream_id' => $liveStream->stream_id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkVideos')) {
            $channelEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'videos',
                'route' => array(
                    'name' => 'channel.rest.video',
                    'params' => array(
                        'channel_id' => $channel->channel_id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkChat')) {
            $channelEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'chat',
                'route' => array(
                    'name' => 'chat.rest.chat',
                    'params' => array(
                        'chat_id' => $chat->chat_id,
                    ),
                ),
            )));
            unset($channelEntity->entity['chat_id']);
        }

        return $channelEntity;
    }
}
