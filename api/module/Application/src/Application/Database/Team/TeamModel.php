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

namespace Application\Database\Team;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * TeamModel
 */
class TeamModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $teamId
     *
     * @return Team|null
     */
    public function fetch(string $teamId)
    {
        $resultSet = $this->tableGateway->select(array('team_id' => $teamId));
        $team = $resultSet->current();
        if (!$team) {
            return null;
        }

        return $team;
    }

    /**
     * @param string $userId
     *
     * @return Select
     */
    public function selectByUser(string $userId)
    {
        $where = new Where();
        $where->equalTo('member.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('member', 'member.team_id = team.team_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $userId
     *
     * @return Team|null
     */
    public function fetchByUser(string $userId)
    {
        return $this->selectAll(
            $this->selectByUser($userId)
        );
    }
}
