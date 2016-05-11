<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Team;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class TeamModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($teamId)
    {
        $resultSet = $this->tableGateway->select(array('team_id' => $teamId));
        $team = $resultSet->current();
        if (!$team) {
            return null;
        }

        return $team;
    }

    public function selectByUser($userId)
    {
        $where = new Where();
        $where->equalTo('member.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('member', 'member.team_id = team.team_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function fetchByUser($userId)
    {
        return $this->selectAll(
            $this->selectByUser($userId)
        );
    }
}
