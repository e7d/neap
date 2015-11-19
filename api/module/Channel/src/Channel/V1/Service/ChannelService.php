<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Channel\V1\Service;
use Application\Database\Channel\Channel;
use Application\Database\User\User;
use Application\Database\Video\Video;
use Channel\V1\Rest\Channel\ChannelCollection;
use Channel\V1\Rest\Follow\FollowCollection;
use Channel\V1\Rest\Video\VideoCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ChannelService
{
    protected $channelModel;
    protected $channelHydrator;
    protected $followModel;
    protected $followHydrator;
    protected $userModel;
    protected $userHydrator;
    protected $videoModel;
    protected $videoHydrator;

    public function __construct($channelModel, $channelHydrator, $followModel, $followHydrator, $userModel, $userHydrator, $videoModel, $videoHydrator)
    {
        $this->channelModel = $channelModel;
        $this->channelHydrator = $channelHydrator;
        $this->followModel = $followModel;
        $this->followHydrator = $followHydrator;
        $this->userModel = $userModel;
        $this->userHydrator = $userHydrator;
        $this->videoModel = $videoModel;
        $this->videoHydrator = $videoHydrator;
    }

    public function fetchAll($params)
    {
        $select = new Select('channel');

        $this->channelHydrator->setParam('linkUser');
        $this->channelHydrator->setParam('linkLiveStream');
        $this->channelHydrator->setParam('linkChat');

        $hydratingResultSet = new HydratingResultSet(
            $this->channelHydrator,
            new Channel()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->channelModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new ChannelCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $channel = $this->channelModel->fetch($id);
        if (!$channel) {
            return null;
        }

        $this->channelHydrator->setParam('embedUser');
        $this->channelHydrator->setParam('embedLiveStream');
        $this->channelHydrator->setParam('linkVideos');
        $this->channelHydrator->setParam('linkChat');

        return $this->channelHydrator->buildEntity($channel);
    }

    public function update($id, $data)
    {
        $channel = $this->channelModel->update($id, $data);

        return $this->channelHydrator->buildEntity($channel);
    }

    public function fetchByUser($userId, $params)
    {
        $channel = $this->channelModel->fetchByUser($userId);
        if (!$channel) {
            return null;
        }

        if (array_key_exists('stream_key', $params)) {
            $this->channelHydrator->setParam('keepStreamKey');
        }
        $this->channelHydrator->setParam('embedUser');
        $this->channelHydrator->setParam('embedLiveStream');
        $this->channelHydrator->setParam('linkVideos');
        $this->channelHydrator->setParam('linkChat');

        return $this->channelHydrator->buildEntity($channel);
    }

    public function fetchFollowers($params)
    {
        $where = new Where();
        $where->equalTo('follow.channel_id', $params['channel_id']);

        $select = new Select('user');
        $select->join('follow', 'follow.user_id = user.user_id', array(), 'inner');
        $select->where($where);

        $hydratingResultSet = new HydratingResultSet(
            $this->userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->userModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new FollowCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchVideos($params)
    {
        $where = new Where();
        $where->equalTo('channel.channel_id', $params['channel_id']);

        $select = new Select('video');
        $select->join('stream', 'stream.stream_id = video.stream_id', array(), 'inner');
        $select->join('channel', 'channel.channel_id = stream.channel_id', array(), 'inner');
        $select->where($where);

        $this->videoHydrator->setParam('linkStream');
        $this->videoHydrator->setParam('linkChannel');
        $this->videoHydrator->setParam('linkUser');

        $hydratingResultSet = new HydratingResultSet(
            $this->videoHydrator,
            new Video()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->videoModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new VideoCollection($paginatorAdapter);
        return $collection;
    }

    public function isOwner($id, $userId)
    {
        $channel = $this->channelModel->fetch($id);

        return $channel->user_id === $userId;
    }
}
