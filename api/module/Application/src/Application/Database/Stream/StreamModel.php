<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Stream;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class StreamModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function create($data)
    {
        $insertedRows = $this->tableGateway->insert($data);
        return $insertedRows;
    }

    public function fetch($streamId)
    {
        $resultSet = $this->tableGateway->select(array('stream_id' => $streamId));
        $stream = $resultSet->current();
        if (!$stream) {
            return null;
        }

        return $stream;
    }

    public function select($live = null)
    {
        $select = $this->tableGateway->getSql()->select();

        if ($live) {
            $where = new Where();
            $where->isNull('stream.ended_at');

            $select->where($where);
        }
        return $select;
    }

    public function selectByChannel($channelId, $live)
    {
        // ToDo: separate into different functions to get the live stream or the collection of stream
        //
        $where = new Where();
        $where->equalTo('channel.channel_id', $channelId);
        if ($live) {
            $where->isNull('stream.ended_at'); // No end date means stream is live
        }

        $select = $this->tableGateway->getSql()->select();
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function fetchByChannel($channelId, $live = null)
    {
        return $this->selectOne(
            $this->selectByChannel($channelId, $live)
        );
    }

    public function selectByStreamKey($streamKey, $live)
    {
        $where = new Where();
        $where->equalTo('channel.stream_key', $streamKey);
        if ($live) {
            $where->isNull('stream.ended_at'); // No end date means stream is live
        }

        $select = $this->tableGateway->getSql()->select();
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function fetchByStreamKey($streamKey, $live = null)
    {
        return $this->selectOne(
            $this->selectByStreamKey($streamKey, $live)
        );
    }

    public function selectByUser($userId, $live)
    {
        // ToDo: separate into different functions to get the live stream or the collection of stream

        $where = new Where();
        $where->equalTo('user.user_id', $userId);
        if ($live) {
            $where->isNull('stream.ended_at'); // No end date means stream is live
        }

        $select = $this->tableGateway->getSql()->select();
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->join('user', 'user.user_id = channel.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    public function fetchByUser($userId, $live = null)
    {
        return $this->selectOne(
            $this->selectByUser($userId, $live)
        );
    }

    public function selectStats($live = null)
    {
        $where = new Where();
        if ($live) {
            $where->isNull('stream.ended_at'); // No end date means stream is live
        }

        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            'streams' => new Expression('COUNT(stream_id)'),
            'viewers' => new Expression('SUM(viewers)'),
        ));
        $select->where($where);

        return $select;
    }

    public function fetchStats($live = null)
    {
        $select = $this->selectStats($live);

        $statement = $this->tableGateway->getAdapter()->createStatement($select->getSqlString());
        $resultSet = $statement->execute();
        $stats = $resultSet->current();

        return $stats;
    }

    public function update($streamId, $data)
    {
        $where = new Where();
        $where->equalTo('stream.stream_id', $streamId);

        $this->tableGateway->update($data, $where);

        return $this->fetch($streamId);
    }
}
