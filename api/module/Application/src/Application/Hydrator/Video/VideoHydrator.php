<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Video;

use Application\Hydrator\Hydrator;
use Application\Database\Channel\ChannelModel;
use Application\Database\Stream\StreamModel;
use Application\Database\User\UserModel;
use ZF\Hal\Entity;

class VideoHydrator extends Hydrator
{
    protected $streamModel;
    protected $channelModel;
    protected $userModel;

    public function __construct(StreamModel $streamModel, ChannelModel $channelModel, UserModel $userModel)
    {
        parent::__construct();
        $this->streamModel = $streamModel;
        $this->channelModel = $channelModel;
        $this->userModel = $userModel;
    }

    public function buildEntity($video)
    {
        $this->object = $video;

        $stream = $this->streamModel->fetch($video->stream_id);
        $channel = $this->channelModel->fetch($stream->channel_id);
        $user = $this->userModel->fetch($channel->user_id);

        $this->entity = new Entity($this->extract($video), $video->video_id);

        $this->addSelfLink();
        $this->addLink('linkStream', $stream);
        $this->addLink('linkChannel', $channel);
        $this->addLink('linkUser', $user);

        return $this->entity;
    }
}
