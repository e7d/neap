<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace Application\Hydrator\Chat;

use Application\Database\Channel\ChannelModel;
use Application\Database\Chat\Chat;
use Application\Database\Chat\ChatModel;
use Application\Database\User\UserModel;
use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

/**
 * ChatHydrator
 */
class ChatHydrator extends Hydrator
{
    /** @var ChatModel */
    protected $chatModel;

    /** @var ChannelModel */
    protected $channelModel;

    /** @var UserModel */
    protected $userModel;

    /**
     * @param ChatModel    $chatModel
     * @param ChannelModel $channelModel
     * @param UserModel    $userModel
     */
    public function __construct(ChatModel $chatModel, ChannelModel $channelModel, UserModel $userModel)
    {
        parent::__construct();
        $this->chatModel = $chatModel;
        $this->channelModel = $channelModel;
        $this->userModel = $userModel;
    }

    /**
     * @param Chat $chat
     *
     * @return Entity
     */
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
