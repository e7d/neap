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
        $this->object = $chat;

        $channel = $this->channelModel->fetch($chat->channel_id);
        $user = $this->userModel->fetch($channel->user_id);

        $this->addEmbed('embedChannel', $channel);
        $this->addEmbed('embedUser', $user);

        $this->entity = new Entity($this->extract($chat), $chat->chat_id);

        $this->addSelfLink();
        $this->addLink('linkChannel', $channel);
        $this->addLink('linkUser', $user);

        return $this->entity;
    }
}
