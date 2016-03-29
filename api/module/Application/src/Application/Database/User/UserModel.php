<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\User;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class UserModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($userId)
    {
        $resultSet = $this->tableGateway->select(array('user_id' => $userId));
        $user = $resultSet->current();
        if (!$user) {
            return null;
        }

        return $user;
    }

    public function selectFollowersByChannel($channelId)
    {
        $where = new Where();
        $where->equalTo('follow.channel_id', $channelId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('follow', 'follow.user_id = user.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function selectBlocksByUser($userId)
    {
        $where = new Where();
        $where->equalTo('block.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('block', 'block.blocked_user_id = user.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function selectByChannel($channelId)
    {
        $where = new Where();
        $where->equalTo('channel.channel_id', $channelId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('channel', 'channel.channel_id = user.channel_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function fetchByChannel($channelId)
    {
        return $this->selectOne(
            $this->selectByChannel($channelId)
        );
    }

    public function selectByTeam($teamId)
    {
        $where = new Where();
        $where->equalTo('member.team_id', $teamId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('member', 'member.user_id = user.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function fetchByTeam($teamId)
    {
        return $this->selectAll(
            $this->selectByTeam($teamId)
        );
    }

    public function update($userId, $data)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);

        return $this->tableGateway->update((array) $data, $where);
    }
}
