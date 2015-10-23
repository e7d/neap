<?php
namespace Application\Database\Stream;

use Application\Database\Hydrator;
use Application\Database\Channel\ChannelModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class StreamHydrator extends Hydrator
{
    protected $params;
    protected $channelModel;
    protected $userModel;

    public function __construct(ChannelModel $channelModel, UserModel $userModel)
    {
        $this->params = array();
        $this->channelModel = $channelModel;
        $this->userModel = $userModel;
    }

    public function buildEntity($stream)
    {
        $channel = $this->channelModel->fetch($stream->channel_id);
        $user = $this->userModel->fetch($channel->user_id);

        if (!$this->getParam('embedChannel')) {
            unset($channel->user_id);
            unset($channel->chat_id);

            $channelEntity = new Entity($channel, $channel->id);
            $channelEntity->getLinks()->add(Link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            $stream->channel = $channelEntity;
            unset($stream->channel_id);
        }

        $streamEntity = new Entity($this->extract($stream), $stream->id);

        $streamEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'stream.rest.stream',
                'params' => array(
                    'stream_id' => $stream->id,
                ),
            ),
        )));

        if ($this->getParam('embedChannel')) {
            $streamEntity->getLinks()->add(Link::factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            unset($stream->channel_id);
        }

        $streamEntity->getLinks()->add(Link::factory(array(
            'rel' => 'user',
            'route' => array(
                'name' => 'user.rest.user',
                'params' => array(
                    'user_id' => $user->id,
                ),
            ),
        )));
        unset($stream->user_id);

        return $streamEntity;
    }
}
