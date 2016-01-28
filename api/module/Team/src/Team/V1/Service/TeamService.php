<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Team\V1\Service;

use Application\Database\Team\Team;
use Application\Database\User\User;
use Team\V1\Rest\Team\TeamCollection;
use User\V1\Rest\User\UserCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TeamService
{
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function fetchAll($params = [])
    {
        $teamModel = $this->services->get('Application\Database\Team\TeamModel');
        $teamHydrator = $this->services->get('Application\Hydrator\Team\TeamHydrator');

        $select = $teamModel->getSqlSelect();

        $teamHydrator->setParam('linkUsers', true);

        $hydratingResultSet = new HydratingResultSet(
            $teamHydrator,
            new Team()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $teamModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new TeamCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($teamId)
    {
        $teamModel = $this->services->get('Application\Database\Team\TeamModel');
        $teamHydrator = $this->services->get('Application\Hydrator\Team\TeamHydrator');

        $team = $teamModel->fetch($teamId);
        if (!$team) {
            return null;
        }

        $teamHydrator->setParam('linkUsers', true);

        return $teamHydrator->buildEntity($team);
    }

    public function fetchUsers($params)
    {
        $userModel = $this->services->get('Application\Database\User\UserModel');
        $userHydrator = $this->services->get('Application\Hydrator\User\UserHydrator');

        $select = $userModel->selectByTeam($params['team_id']);

        $userHydrator->setParam('linkChannel', true);

        $hydratingResultSet = new HydratingResultSet(
            $userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $userModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new UserCollection($paginatorAdapter);
        return $collection;
    }
}
