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
use Application\Database\Panel\PanelModel;
use Application\Database\Stream\StreamModel;
use Application\Database\User\UserModel;
use ZF\Hal\Entity;

class ChannelHydrator extends Hydrator
{
    protected $chatModel;
    protected $panelModel;
    protected $streamModel;
    protected $userModel;

    public function __construct(
        ChatModel $chatModel,
        PanelModel $panelModel,
        StreamModel $streamModel,
        UserModel $userModel
    ) {
        parent::__construct();
        $this->chatModel = $chatModel;
        $this->panelModel = $panelModel;
        $this->streamModel = $streamModel;
        $this->userModel = $userModel;
    }

    public function buildEntity($channel)
    {
        $this->object = $channel;

        $user = $this->userModel->fetch($channel->user_id);
        $chat = $this->chatModel->fetch($channel->chat_id);
        $liveStream = $this->streamModel->fetchByChannel($channel->channel_id, $live = true);

        if (!$this->getParam('keepStreamKey')) {
            unset($channel->stream_key);
        }

        $this->addEmbed('embedUser', $user);
        $this->addEmbed('embedLiveStream', $liveStream);

        $this->entity = new Entity($this->extract($channel), $channel->channel_id);

        $this->addSelfLink();
        $this->addLink('linkUser', $user);
        $this->addLink('linkLiveStream', $liveStream);
        $this->addLink('linkPanels', $channel, 'panels', 'channel.rest.panel');
        $this->addLink('linkVideos', $channel, 'videos', 'channel.rest.video');
        $this->addLink('linkChat', $chat);

        return $this->entity;
    }
}
