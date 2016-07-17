<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Team;

use Application\Database\Team\Team;
use Application\Database\User\UserModel;
use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

/**
 * TeamHydrator
 */
class TeamHydrator extends Hydrator
{
    /** @var UserModel */
    protected $userModel;

    /**
     * @param UserModel $userModel
     */
    public function __construct(UserModel $userModel)
    {
        parent::__construct();
        $this->userModel = $userModel;
    }

    /**
     * @param Team $team
     *
     * @return Entity
     */
    public function buildEntity($team)
    {
        $this->object = $team;

        $this->entity = new Entity($this->extract($team), $team->team_id);

        $this->addSelfLink();
        $this->addLink('linkUsers', $team, 'users', 'team.rest.user');

        return $this->entity;
    }
}
