<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\User;

use Application\Database\Hydrator;
use Application\Database\Channel\ChannelModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class UserHydrator extends Hydrator
{
    protected $userModel;
    protected $channelModel;

    public function __construct(UserModel $userModel, ChannelModel $channelModel)
    {
        $this->userModel = $userModel;
        $this->channelModel = $channelModel;
    }

    public function buildEntity($user)
    {
        $channel = $this->channelModel->fetch($user->channel_id);

        if ($this->getParam('embed_channel')) {
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
            $user->channel = $channelEntity;
            unset($user->channel_id);
        }

        $userEntity = new Entity($this->extract($user), $user->id);

        $userEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'user.rest.user',
                'params' => array(
                    'user_id' => $user->id,
                ),
            ),
        )));

        if (!$this->getParam('embedChannel')) {
            $userEntity->getLinks()->add(Link::factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            unset($user->channel_id);
        }

        return $userEntity;
    }
}
