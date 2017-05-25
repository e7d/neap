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

namespace Team\V1\Service;

use Application\Database\Team\Team;
use Application\Database\User\User;
use Team\V1\Rest\Team\TeamCollection;
use Team\V1\Rest\User\UserCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;

class TeamService
{
    private $serviceManager;

    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function fetchAll($params = [])
    {
        $teamModel = $this->serviceManager->get('Application\Database\Team\TeamModel');
        $teamHydrator = $this->serviceManager->get('Application\Hydrator\Team\TeamHydrator');

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
        $teamModel = $this->serviceManager->get('Application\Database\Team\TeamModel');
        $teamHydrator = $this->serviceManager->get('Application\Hydrator\Team\TeamHydrator');

        $team = $teamModel->fetch($teamId);
        if (!$team) {
            return null;
        }

        $teamHydrator->setParam('linkUsers', true);

        return $teamHydrator->buildEntity($team);
    }

    public function fetchUsers($params)
    {
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');
        $userHydrator = $this->serviceManager->get('Application\Hydrator\User\UserHydrator');

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
