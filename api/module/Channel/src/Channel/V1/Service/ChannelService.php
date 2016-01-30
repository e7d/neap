<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Channel\V1\Service;

use Application\Database\Channel\Channel;
use Application\Database\User\User;
use Application\Database\Panel\Panel;
use Application\Database\Video\Video;
use Channel\V1\Rest\Channel\ChannelCollection;
use Channel\V1\Rest\Follow\FollowCollection;
use Channel\V1\Rest\Panel\PanelCollection;
use Channel\V1\Rest\Video\VideoCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;

class ChannelService
{
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function fetchAll($params = [])
    {
        $channelModel = $this->services->get('Application\Database\Channel\ChannelModel');
        $channelHydrator = $this->services->get('Application\Hydrator\Channel\ChannelHydrator');

        $select = $channelModel->getSqlSelect();

        $channelHydrator->setParam('linkUser', true);
        $channelHydrator->setParam('linkLiveStream', true);
        $channelHydrator->setParam('linkPanels', true);
        $channelHydrator->setParam('linkVideos', true);
        $channelHydrator->setParam('linkChat', true);

        $hydratingResultSet = new HydratingResultSet(
            $channelHydrator,
            new Channel()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $channelModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new ChannelCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($channelId)
    {
        $channelModel = $this->services->get('Application\Database\Channel\ChannelModel');
        $channelHydrator = $this->services->get('Application\Hydrator\Channel\ChannelHydrator');

        $channel = $channelModel->fetch($channelId);
        if (!$channel) {
            return null;
        }

        $channelHydrator->setParam('embedUser', true);
        $channelHydrator->setParam('embedLiveStream', true);
        $channelHydrator->setParam('linkPanels', true);
        $channelHydrator->setParam('linkVideos', true);
        $channelHydrator->setParam('linkChat', true);

        return $channelHydrator->buildEntity($channel);
    }

    public function update($channelId, $data)
    {
        $channelModel = $this->services->get('Application\Database\Channel\ChannelModel');
        $channelHydrator = $this->services->get('Application\Hydrator\Channel\ChannelHydrator');

        $channel = $channelModel->update($channelId, $data);

        return $channelHydrator->buildEntity($channel);
    }

    public function fetchByStreamKey($streamKey)
    {
        $channelModel = $this->services->get('Application\Database\Channel\ChannelModel');

        return $channelModel->fetchByStreamKey($streamKey);
    }

    public function fetchByUser($userId, $params)
    {
        $channelModel = $this->services->get('Application\Database\Channel\ChannelModel');
        $channelHydrator = $this->services->get('Application\Hydrator\Channel\ChannelHydrator');

        $channel = $channelModel->fetchByUser($userId);
        if (!$channel) {
            return null;
        }

        if (array_key_exists('stream_key', $params)) {
            $channelHydrator->setParam('keepStreamKey');
        }
        $channelHydrator->setParam('embedUser', true);
        $channelHydrator->setParam('embedLiveStream', true);
        $channelHydrator->setParam('linkPanels', true);
        $channelHydrator->setParam('linkVideos', true);
        $channelHydrator->setParam('linkChat', true);

        return $channelHydrator->buildEntity($channel);
    }

    public function fetchFollowers($params)
    {
        $userModel = $this->services->get('Application\Database\User\UserModel');
        $userHydrator = $this->services->get('Application\Hydrator\User\UserHydrator');

        $select = $userModel->selectFollowersByChannel($params['channel_id']);

        $hydratingResultSet = new HydratingResultSet(
            $userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $userModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new FollowCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchPanels($params)
    {
        $panelModel = $this->services->get('Application\Database\Panel\PanelModel');
        $panelHydrator = $this->services->get('Application\Hydrator\Panel\PanelHydrator');

        $select = $panelModel->selectByChannel($params['channel_id']);

        $hydratingResultSet = new HydratingResultSet(
            $panelHydrator,
            new Panel()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $panelModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new PanelCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchVideos($params)
    {
        $videoModel = $this->services->get('Application\Database\Video\VideoModel');
        $videoHydrator = $this->services->get('Application\Hydrator\Video\VideoHydrator');

        $select = $videoModel->selectByChannel($params['channel_id']);

        $videoHydrator->setParam('linkStream', true);
        $videoHydrator->setParam('linkChannel', true);
        $videoHydrator->setParam('linkUser', true);

        $hydratingResultSet = new HydratingResultSet(
            $videoHydrator,
            new Video()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $videoModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new VideoCollection($paginatorAdapter);
        return $collection;
    }

    public function isOwner($channelId, $userId)
    {
        $channelModel = $this->services->get('Application\Database\Channel\ChannelModel');

        $channel = $channelModel->fetch($channelId);
        if (is_null($channel)) {
            return false;
        }

        return $channel->user_id === $userId;
    }
}
