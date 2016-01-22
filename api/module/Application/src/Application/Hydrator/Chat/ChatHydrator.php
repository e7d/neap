<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Chat;

use Application\Hydrator\Hydrator;
use Application\Database\Chat\ChatModel;
use Application\Database\Channel\ChannelModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;

class ChatHydrator extends Hydrator
{
    protected $chatModel;
    protected $channelModel;
    protected $userModel;

    public function __construct(ChatModel $chatModel, ChannelModel $channelModel, UserModel $userModel)
    {
        parent::__construct();
        $this->chatModel = $chatModel;
        $this->channelModel = $channelModel;
        $this->userModel = $userModel;
    }

    public function buildEntity($chat)
    {
        $chat = $this->chatModel->fetch($chat->id);
        $channel = $this->channelModel->fetch($chat->channel_id);
        $user = $this->userModel->fetch($channel->user_id);

        if ($this->getParam('embedChannel')) {
            $channelEntity = new Entity($channel, $channel->id);
            $channelEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            $chat->channel = $channelEntity;
            unset($chat->channel_id);
        }

        if ($this->getParam('embedUser')) {
            $userEntity = new Entity($user, $user->id);
            $userEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->id,
                    ),
                ),
            )));
            $chat->user = $userEntity;
        }

        $chatEntity = new Entity($this->extract($chat), $chat->id);

        $chatEntity->getLinks()->add($this->link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'chat.rest.chat',
                'params' => array(
                    'chat_id' => $chat->id,
                ),
            ),
        )));

        if ($this->getParam('linkChannel')) {
            $chatEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            unset($chat->channel_id);
        }

        if ($this->getParam('linkUser')) {
            $chatEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'user',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->id,
                    ),
                ),
            )));
        }

        return $chatEntity;
    }
}
