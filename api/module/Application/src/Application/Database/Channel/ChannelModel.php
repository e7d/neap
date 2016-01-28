<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Channel;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class ChannelModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($channelId)
    {
        $resultSet = $this->tableGateway->select(array('channel_id' => $channelId));
        $channel = $resultSet->current();
        if (!$channel) {
            return null;
        }

        return $channel;
    }

    public function selectByStreamKey($streamKey)
    {
        $where = new Where();
        $where->equalTo('channel.stream_key', $streamKey);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    public function fetchByStreamKey($streamKey)
    {
        return $this->selectOne(
            $this->selectByStreamKey($streamKey)
        );
    }

    public function selectByUser($userId)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('user', 'user.user_id = channel.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function fetchByUser($userId)
    {
        return $this->selectOne(
            $this->selectByUser($userId)
        );
    }

    public function selectFollowsByUser($userId)
    {
        $where = new Where();
        $where->equalTo('follow.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('follow', 'follow.channel_id = channel.channel_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function fetchFollowsByUser($userId)
    {
        return $this->selectAll(
            $this->selectFollowsByUser($userId)
        );
    }

    public function update($channelId, $data)
    {
        $where = new Where();
        $where->equalTo('channel.channel_id', $channelId);

        $this->tableGateway->update($data, $where);

        return $this->fetch($channelId);
    }
}
