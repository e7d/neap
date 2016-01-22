<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Stream;

use Application\Hydrator\Hydrator;
use Application\Database\Channel\ChannelModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;

class StreamHydrator extends Hydrator
{
    protected $channelModel;
    protected $userModel;

    public function __construct(ChannelModel $channelModel, UserModel $userModel)
    {
        parent::__construct();
        $this->channelModel = $channelModel;
        $this->userModel = $userModel;
    }

    public function buildEntity($stream)
    {
        $channel = $this->channelModel->fetch($stream->channel_id);
        $user = $this->userModel->fetch($channel->user_id);

        if (!$this->getParam('keepStreamKey')) {
            unset($channel->stream_key);
        }

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
            $stream->channel = $channelEntity;
            unset($stream->channel_id);
        }

        $streamEntity = new Entity($this->extract($stream), $stream->id);

        $streamEntity->getLinks()->add($this->link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'stream.rest.stream',
                'params' => array(
                    'stream_id' => $stream->id,
                ),
            ),
        )));

        if ($this->getParam('linkChannel')) {
            $streamEntity->getLinks()->add($this->link::factory(array(
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

        if ($this->getParam('linkUser')) {
            $streamEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'user',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->id,
                    ),
                ),
            )));
        }

        return $streamEntity;
    }
}
