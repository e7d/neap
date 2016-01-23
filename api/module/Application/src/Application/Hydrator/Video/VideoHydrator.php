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
use Zend\Stdlib\Hydrator\HydratorInterface;
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
        $stream = $this->streamModel->fetch($video->stream_id);
        $channel = $this->channelModel->fetch($stream->channel_id);
        $user = $this->userModel->fetch($channel->user_id);

        $videoEntity = new Entity($this->extract($video), $video->video_id);

        $videoEntity->getLinks()->add($this->link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'video.rest.video',
                'params' => array(
                    'video_id' => $video->video_id,
                ),
            ),
        )));

        if ($this->getParam('linkStream')) {
            $videoEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'stream',
                'route' => array(
                    'name' => 'stream.rest.stream',
                    'params' => array(
                        'stream_id' => $stream->stream_id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkChannel')) {
            $videoEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->channel_id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkUser')) {
            $videoEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'user',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->user_id,
                    ),
                ),
            )));
        }

        return $videoEntity;
    }
}
