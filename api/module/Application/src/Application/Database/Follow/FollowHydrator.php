<?php
namespace Application\Database\Follow;

use Application\Database\Hydrator;
use Application\Database\Channel\ChannelModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class FollowHydrator extends Hydrator
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

    public function buildEntity($follow)
    {
        $channel = $this->channelModel->fetch($follow->channel_id);
        $user = $this->userModel->fetch($follow->user_id);

        if ($this->getParam('embedChannel')) {
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
            $follow->channel = $channelEntity;
            unset($follow->channel_id);
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
            $follow->user = $userEntity;
            unset($follow->user_id);
        }

        $followEntity = new Entity($this->extract($follow));

        $followEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'channel.rest.follow',
                'params' => array(
                    'channel_id' => $channel->id,
                    'user_id' => $user->id,
                ),
            ),
        )));

        if (!$this->getParam('embedChannel')) {
            $followEntity->getLinks()->add(Link::factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
        }

        if (!$this->getParam('embedUser')) {
            $followEntity->getLinks()->add(Link::factory(array(
                'rel' => 'user',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->id,
                    ),
                ),
            )));
        }

        return $followEntity;
    }
}
