<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Team;

use Application\Hydrator\Hydrator;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;

class TeamHydrator extends Hydrator
{
    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        parent::__construct();
        $this->userModel = $userModel;
    }

    public function buildEntity($team)
    {
        $teamEntity = new Entity($this->extract($team), $team->team_id);

        $teamEntity->getLinks()->add($this->link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'team.rest.team',
                'params' => array(
                    'team_id' => $team->team_id,
                ),
            ),
        )));

        if ($this->getParam('linkUsers')) {
            $teamEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'users',
                'route' => array(
                    'name' => 'team.rest.user',
                    'params' => array(
                        'team_id' => $team->team_id,
                    ),
                ),
            )));
        }

        return $teamEntity;
    }
}
