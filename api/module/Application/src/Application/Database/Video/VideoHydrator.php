<?php
namespace Application\Database\Video;

use Application\Database\Channel\ChannelModel;
use Application\Database\Stream\StreamModel;
use Application\Database\User\UserModel;
use Application\Database\Video\Video;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class VideoHydrator implements HydratorInterface
{
    protected $params;
    protected $streamModel;
    protected $channelModel;
    protected $userModel;

    public function __construct(StreamModel $streamModel, ChannelModel $channelModel, UserModel $userModel)
    {
        $this->params = array();
        $this->streamModel = $streamModel;
        $this->channelModel = $channelModel;
        $this->userModel = $userModel;
    }

    public function hydrate(array $data, $video)
    {
        $video->exchangeArray($data);
        $videoEntity = $this->buildEntity($video);
        return $videoEntity;
    }

    public function extract($object)
    {
        return get_object_vars($object);
    }

    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function buildEntity($video)
    {
        $stream = $this->streamModel->fetch($video->stream_id);
        $channel = $this->channelModel->fetch($stream->channel_id);
        $user = $this->userModel->fetch($channel->user_id);

        $videoEntity = new Entity($this->extract($video), $video->id);

        $videoEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'video.rest.video',
                'params' => array(
                    'video_id' => $video->id,
                ),
            ),
        )));

        $videoEntity->getLinks()->add(Link::factory(array(
            'rel' => 'stream',
            'route' => array(
                'name' => 'stream.rest.stream',
                'params' => array(
                    'stream_id' => $stream->id,
                ),
            ),
        )));

        $videoEntity->getLinks()->add(Link::factory(array(
            'rel' => 'channel',
            'route' => array(
                'name' => 'channel.rest.channel',
                'params' => array(
                    'channel_id' => $channel->id,
                ),
            ),
        )));

        $videoEntity->getLinks()->add(Link::factory(array(
            'rel' => 'user',
            'route' => array(
                'name' => 'user.rest.user',
                'params' => array(
                    'user_id' => $user->id,
                ),
            ),
        )));

        return $videoEntity;
    }
}
