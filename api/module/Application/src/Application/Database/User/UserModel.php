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

/**
 * UserModel
 */
class UserModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $userId
     *
     * @return User|null
     */
    public function fetch(string $userId)
    {
        $resultSet = $this->tableGateway->select(array('user_id' => $userId));
        $user = $resultSet->current();
        if (!$user) {
            return null;
        }

        return $user;
    }

    /**
     * @param string $channelId
     *
     * @return Select
     */
    public function selectFollowersByChannel(string $channelId)
    {
        $where = new Where();
        $where->equalTo('follow.channel_id', $channelId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('follow', 'follow.user_id = user.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $userId
     *
     * @return Select
     */
    public function selectBlocksByUser(string $userId)
    {
        $where = new Where();
        $where->equalTo('block.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('block', 'block.blocked_user_id = user.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $channelId
     *
     * @return Select
     */
    public function selectByChannel(string $channelId)
    {
        $where = new Where();
        $where->equalTo('channel.channel_id', $channelId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('channel', 'channel.channel_id = user.channel_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $channelId
     *
     * @return User|null
     */
    public function fetchByChannel(string $channelId)
    {
        return $this->selectOne(
            $this->selectByChannel($channelId)
        );
    }


    /**
     * @param string $teamId
     *
     * @return Select
     */
    public function selectByTeam(string $teamId)
    {
        $where = new Where();
        $where->equalTo('member.team_id', $teamId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('member', 'member.user_id = user.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $teamId
     *
     * @return User|null
     */
    public function fetchByTeam(string $teamId)
    {
        return $this->selectAll(
            $this->selectByTeam($teamId)
        );
    }

    /**
     * @param string $userId
     * @param array  $data
     *
     * @return bool
     */
    public function update(string $userId, array $data)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);

        return $this->tableGateway->update($data, $where);
    }
}
