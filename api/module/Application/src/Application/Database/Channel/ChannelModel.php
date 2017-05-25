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

namespace Application\Database\Channel;

use Application\Database\AbstractModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * ChannelModel
 */
class ChannelModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $channelId
     *
     * @return Channel|null
     */
    public function fetch(string $channelId)
    {
        $resultSet = $this->tableGateway->select(array('channel_id' => $channelId));
        $channel = $resultSet->current();
        if (!$channel) {
            return null;
        }

        return $channel;
    }

    /**
     * @param string $streamKey
     *
     * @return Select
     */
    public function selectByStreamKey(string $streamKey)
    {
        $where = new Where();
        $where->equalTo('channel.stream_key', $streamKey);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    /**
     * @param string $streamKey
     *
     * @return Channel|null
     */
    public function fetchByStreamKey(string $streamKey)
    {
        return $this->selectOne(
            $this->selectByStreamKey($streamKey)
        );
    }

    /**
     * @param string $userId
     *
     * @return Select
     */
    public function selectByUser(string $userId)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('user', 'user.user_id = channel.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $userId
     *
     * @return Channel|null
     */
    public function fetchByUser(string $userId)
    {
        return $this->selectOne(
            $this->selectByUser($userId)
        );
    }

    /**
     * @param string $userId
     *
     * @return Select
     */
    public function selectFollowsByUser(string $userId)
    {
        $where = new Where();
        $where->equalTo('follow.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('follow', 'follow.channel_id = channel.channel_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $userId
     *
     * @return ResultSet
     */
    public function fetchFollowsByUser(string $userId)
    {
        return $this->selectAll(
            $this->selectFollowsByUser($userId)
        );
    }

    /**
     * @param string $channelId
     * @param array  $data
     *
     * @return bool
     */
    public function update(string $channelId, array $data)
    {
        $where = new Where();
        $where->equalTo('channel.channel_id', $channelId);

        return $this->tableGateway->update($data, $where);
    }
}
