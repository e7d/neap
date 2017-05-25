<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace Application\Hydrator\User;

use Application\Database\Channel\ChannelModel;
use Application\Database\User\User;
use Application\Database\User\UserModel;
use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

/**
 * UserHydrator
 */
class UserHydrator extends Hydrator
{
    /** @var UserModel */
    protected $userModel;

    /** @var ChannelModel */
    protected $channelModel;

    /**
     * @param UserModel    $userModel
     * @param ChannelModel $channelModel
     */
    public function __construct(UserModel $userModel, ChannelModel $channelModel)
    {
        parent::__construct();
        $this->userModel = $userModel;
        $this->channelModel = $channelModel;
    }

    /**
     * @param User $user
     *
     * @return Entity
     */
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
