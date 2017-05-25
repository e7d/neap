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

namespace Application\Database\Stream;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * StreamModel
 */
class StreamModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function create(array $data)
    {
        $insertedRows = $this->tableGateway->insert($data);
        return $insertedRows;
    }

    /**
     * @param string $streamId
     *
     * @return Stream|null
     */
    public function fetch(string $streamId)
    {
        $resultSet = $this->tableGateway->select(array('stream_id' => $streamId));
        $stream = $resultSet->current();
        if (!$stream) {
            return null;
        }

        return $stream;
    }

    /**
     * @param bool $live
     *
     * @return Select
     */
    public function select(bool $live = false)
    {
        $select = $this->tableGateway->getSql()->select();

        if ($live) {
            $where = new Where();
            $where->isNull('stream.ended_at');

            $select->where($where);
        }
        return $select;
    }

    /**
     * @param string $channelId
     * @param bool   $live
     *
     * @return Select
     */
    public function selectByChannel(string $channelId, bool $live)
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

    /**
     * @param string $channelId
     * @param bool   $live
     *
     * @return Stream|null
     */
    public function fetchByChannel(string $channelId, bool $live = false)
    {
        return $this->selectOne(
            $this->selectByChannel($channelId, $live)
        );
    }

    /**
     * @param string $streamKey
     * @param bool   $live
     *
     * @return Select
     */
    public function selectByStreamKey(string $streamKey, bool $live)
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

    /**
     * @param string $streamKey
     * @param bool   $live
     *
     * @return Stream|null
     */
    public function fetchByStreamKey(string $streamKey, bool $live = false)
    {
        return $this->selectOne(
            $this->selectByStreamKey($streamKey, $live)
        );
    }

    /**
     * @param string $userId
     * @param bool   $live
     *
     * @return Select
     */
    public function selectByUser(string $userId, bool $live)
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

    /**
     * @param string $userId
     * @param bool   $live
     *
     * @return Stream|null
     */
    public function fetchByUser(string $userId, bool $live = false)
    {
        return $this->selectOne(
            $this->selectByUser($userId, $live)
        );
    }


    /**
     * @param bool $live
     *
     * @return Select
     */
    public function selectStats(bool $live)
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

    /**
     * @param bool $live
     *
     * @return Stream|null
     */
    public function fetchStats(bool $live = false)
    {
        $select = $this->selectStats($live);

        $statement = $this->tableGateway->getAdapter()->createStatement($select->getSqlString());
        $resultSet = $statement->execute();
        $stats = $resultSet->current();

        return $stats;
    }

    /**
     * @param string $streamId
     * @param array  $data
     *
     * @return Stream|null
     */
    public function update(string $streamId, array $data)
    {
        $where = new Where();
        $where->equalTo('stream.stream_id', $streamId);

        $this->tableGateway->update($data, $where);

        return $this->fetch($streamId);
    }
}
