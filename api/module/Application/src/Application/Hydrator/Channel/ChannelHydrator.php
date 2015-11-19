<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Hydrator\Channel;

use Application\Hydrator\Hydrator;
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
        $stream = $this->streamModel->fetchByChannel($channel->id);

        if (!$this->getParam('keepStreamKey')) {
            unset($channel->stream_key);
        }

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

        if ($this->getParam('embedLiveStream') && !is_null($stream)) {
            $streamEntity = new Entity($stream, $stream->id);
            $streamEntity->getLinks()->add(Link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'stream.rest.stream',
                    'params' => array(
                        'stream_id' => $stream->id,
                    ),
                ),
            )));
            $channel->stream = $streamEntity;
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

        if ($this->getParam('linkUser')) {
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

        if ($this->getParam('linkLiveStream') && !is_null($stream)) {
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

        if ($this->getParam('linkVideos')) {
            $channelEntity->getLinks()->add(Link::factory(array(
                'rel' => 'videos',
                'route' => array(
                    'name' => 'channel.rest.video',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkChat')) {
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
        }

        if ($this->getParam('linkStream') && !is_null($stream)) {
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
