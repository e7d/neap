<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\User;

use Application\Hydrator\Hydrator;
use Application\Database\Channel\ChannelModel;
use Application\Database\User\UserModel;
use Application\Database\Team\TeamModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class UserHydrator extends Hydrator
{
    protected $userModel;
    protected $channelModel;

    public function __construct(UserModel $userModel, ChannelModel $channelModel)
    {
        parent::__construct();
        $this->userModel = $userModel;
        $this->channelModel = $channelModel;
    }

    public function buildEntity($user)
    {
        $channel = $this->channelModel->fetch($user->channel_id);
        unset($channel->stream_key);

        if ($this->getParam('embedChannel')) {
            $channelEntity = new Entity($channel, $channel->channel_id);
            $channelEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->channel_id,
                    ),
                ),
            )));
            $user->channel = $channelEntity;
            unset($user->channel_id);
        }

        $userEntity = new Entity($this->extract($user), $user->user_id);

        $userEntity->getLinks()->add($this->link->factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'user.rest.user',
                'params' => array(
                    'user_id' => $user->user_id,
                ),
            ),
        )));

        if ($this->getParam('linkBlock')) {
            $userEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'blocks',
                'route' => array(
                    'name' => 'user.rest.block',
                    'params' => array(
                        'user_id' => $user->user_id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkChannel')) {
            $userEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->channel_id,
                    ),
                ),
            )));
            unset($user->channel_id);
        }

        if ($this->getParam('linkFavorite')) {
            $userEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'favorites',
                'route' => array(
                    'name' => 'user.rest.favorite',
                    'params' => array(
                        'user_id' => $user->user_id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkFollow')) {
            $userEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'follows',
                'route' => array(
                    'name' => 'user.rest.follow',
                    'params' => array(
                        'user_id' => $user->user_id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkMod')) {
            $userEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'mods',
                'route' => array(
                    'name' => 'user.rest.mod',
                    'params' => array(
                        'user_id' => $user->user_id,
                    ),
                ),
            )));
        }

        if ($this->getParam('linkTeams')) {
            $userEntity->getLinks()->add($this->link->factory(array(
                'rel' => 'teams',
                'route' => array(
                    'name' => 'user.rest.team',
                    'params' => array(
                        'user_id' => $user->user_id,
                    ),
                ),
            )));
        }

        return $userEntity;
    }
}
