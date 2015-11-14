<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Stream;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class StreamModel
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
        $rowset = $this->tableGateway->select(array('stream_id' => $id));
        $stream = $rowset->current();
        if (!$stream) {
            return null;
        }

        return $stream;
    }

    public function fetchByChannel($channelId, $live = true)
    {
        $where = new Where();
        $where->equalTo('channel.channel_id', $channelId);
        if ($live) {
            $where->isNull('stream.ended_at'); // No end date means stream is live
        }

        $select = $this->tableGateway->getSql()->select();
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->where($where);

        $rowset = $this->tableGateway->selectWith($select);
        $stream = $rowset->current();
        if (!$stream) {
            return null;
        }

        return $stream;
    }

    public function fetchByUser($userId, $live = true)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);
        if ($live) {
            $where->isNull('stream.ended_at'); // No end date means stream is live
        }

        $select = $this->tableGateway->getSql()->select();
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->join('user', 'user.user_id = channel.user_id', array(), 'inner');
        $select->where($where);

        $rowset = $this->tableGateway->selectWith($select);
        $stream = $rowset->current();
        if (!$stream) {
            return null;
        }

        return $stream;
    }
}
