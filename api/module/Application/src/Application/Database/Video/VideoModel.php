<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Video;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * VideoModel
 */
class VideoModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $videoId
     *
     * @return Video|null
     */
    public function fetch(string $videoId)
    {
        $resultSet = $this->tableGateway->select(array('video_id' => $videoId));
        $video = $resultSet->current();
        if (!$video) {
            return null;
        }

        return $video;
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

        $select = new Select('video');
        $select->join('stream', 'stream.stream_id = video.stream_id', array(), 'inner');
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $channelId
     *
     * @return Video|null
     */
    public function fetchByChannel(string $channelId)
    {
        return $this->selectAll(
            $this->selectByChannel($channelId)
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
        $select->join('stream', 'stream.stream_id = video.stream_id', array(), 'inner');
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->join('user', 'user.user_id = channel.user_id', array(), 'inner');
        $select->where($where);

        return $select;
    }

    /**
     * @param string $userId
     *
     * @return Video|null
     */
    public function fetchByUser(string $userId)
    {
        return $this->selectAll(
            $this->selectByUser($userId)
        );
    }

    /**
     * @param string $userId
     *
     * @return Select
     */
    public function selectFavoritesByUser(string $userId)
    {
        $where = new Where();
        $where->equalTo('favorite.user_id', $userId);

        $select = new Select('video');
        $select->join('favorite', 'favorite.video_id = video.video_id', array(), 'inner');
        $select->where($where);

        return $select;
    }
}
