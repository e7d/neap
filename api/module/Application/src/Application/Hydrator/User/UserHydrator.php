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
        $this->object = $user;

        $channel = $this->channelModel->fetch($user->channel_id);
        unset($channel->stream_key);

        $this->addEmbed('embedChannel', $channel);

        $this->entity = new Entity($this->extract($user), $user->user_id);

        $this->addSelfLink();
        $this->addLink('linkBlock', $user, 'blocks', 'user.rest.block');
        $this->addLink('linkChannel', $channel);
        $this->addLink('linkFavorite', $user, 'favorites', 'user.rest.favorite');
        $this->addLink('linkFollow', $user, 'follows', 'user.rest.follow');
        $this->addLink('linkMod', $user, 'mods', 'user.rest.mod');
        $this->addLink('linkTeams', $user, 'teams', 'user.rest.team');

        return $this->entity;
    }
}
