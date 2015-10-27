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
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
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

        $sqlSelect = $this->tableGateway->getSql()->select()->where($where);
        $sqlSelect->join('stream', 'stream.stream_id = video.stream_id', array(), 'left');
        $sqlSelect->join('channel', 'channel.channel_id = stream.channel_id', array(), 'left');
        $sqlSelect->join('user', 'user.user_id = channel.user_id', array(), 'left');

        $rowset = $this->tableGateway->selectWith($sqlSelect);
        $video = $rowset->current();
        if (!$video) {
            return null;
        }

        return $video;
    }
}
