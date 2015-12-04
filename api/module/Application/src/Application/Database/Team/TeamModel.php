<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Team;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class TeamModel
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function fetch($id)
    {
        $rowset = $this->tableGateway->select(array('team_id' => $id));
        $team = $rowset->current();
        if (!$team) {
            return null;
        }

        return $team;
    }

    public function fetchByUser($userId)
    {
        $where = new Where();
        $where->equalTo('member.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('member', 'member.team_id = team.team_id', array(), 'inner');
        $select->where($where);

        $rowset = $this->tableGateway->selectWith($select);
        $team = $rowset->current();
        if (!$team) {
            return null;
        }

        return $team;
    }
}
