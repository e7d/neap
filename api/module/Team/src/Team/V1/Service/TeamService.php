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
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TeamService
{
    protected $teamModel;
    protected $teamHydrator;
    protected $userModel;
    protected $userHydrator;

    public function __construct($teamModel, $teamHydrator, $userModel, $userHydrator)
    {
        $this->teamModel = $teamModel;
        $this->teamHydrator = $teamHydrator;
        $this->userModel = $userModel;
        $this->userHydrator = $userHydrator;
    }

    public function fetchAll($params = [])
    {
        $select = new Select('team');

        $this->teamHydrator->setParam('linkUsers');

        $hydratingResultSet = new HydratingResultSet(
            $this->teamHydrator,
            new Team()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->teamModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new TeamCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $team = $this->teamModel->fetch($id);
        if (!$team) {
            return null;
        }

        $this->teamHydrator->setParam('linkUsers');

        return $this->teamHydrator->buildEntity($team);
    }

    public function fetchUsers($params)
    {
        $where = new Where();
        $where->equalTo('member.team_id', $params['team_id']);

        $select = new Select('user');
        $select->join('member', 'member.user_id = user.user_id', array(), 'inner');
        $select->where($where);

        $this->userHydrator->setParam('linkChannel');

        $hydratingResultSet = new HydratingResultSet(
            $this->userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->userModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new UserCollection($paginatorAdapter);
        return $collection;
    }
}
