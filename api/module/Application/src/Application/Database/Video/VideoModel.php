<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Video;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class VideoModel
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
        $rowset = $this->tableGateway->select(array('video_id' => $id));
        $video = $rowset->current();
        if (!$video) {
            return null;
        }

        return $video;
    }

    public function fetchByUser($userId)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('stream', 'stream.stream_id = video.stream_id', array(), 'inner');
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->join('user', 'user.user_id = channel.user_id', array(), 'inner');
        $select->where($where);

        $rowset = $this->tableGateway->selectWith($select);
        $video = $rowset->current();
        if (!$video) {
            return null;
        }

        return $video;
    }
}
