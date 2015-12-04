<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Hydrator\Team;

use Application\Hydrator\Hydrator;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class TeamHydrator extends Hydrator
{
    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function buildEntity($team)
    {
        $teamEntity = new Entity($this->extract($team), $team->id);

        $teamEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'team.rest.team',
                'params' => array(
                    'team_id' => $team->id,
                ),
            ),
        )));

        if ($this->getParam('linkUsers')) {
            $teamEntity->getLinks()->add(Link::factory(array(
                'rel' => 'users',
                'route' => array(
                    'name' => 'team.rest.user',
                    'params' => array(
                        'team_id' => $team->id,
                    ),
                ),
            )));
        }

        return $teamEntity;
    }
}
