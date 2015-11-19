<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace User\V1\Service;

use Application\Database\Channel\Channel;
use Application\Database\Chat\Chat;
use Application\Database\User\User;
use Application\Database\Video\Video;
use User\V1\Rest\Block\BlockCollection;
use User\V1\Rest\Favorite\FavoriteCollection;
use User\V1\Rest\Follow\FollowCollection;
use User\V1\Rest\Mod\ModCollection;
use User\V1\Rest\User\UserCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class UserService
{
    protected $channelModel;
    protected $channelHydrator;
    protected $chatModel;
    protected $chatHydrator;
    protected $userModel;
    protected $userHydrator;
    protected $videoModel;
    protected $videoHydrator;

    public function __construct($channelModel, $channelHydrator, $chatModel, $chatHydrator, $userModel, $userHydrator, $videoModel, $videoHydrator)
    {
        $this->channelModel = $channelModel;
        $this->channelHydrator = $channelHydrator;
        $this->chatModel = $chatModel;
        $this->chatHydrator = $chatHydrator;
        $this->userModel = $userModel;
        $this->userHydrator = $userHydrator;
        $this->videoModel = $videoModel;
        $this->videoHydrator = $videoHydrator;
    }

    public function fetch($id)
    {
        $user = $this->userModel->fetch($id);
        if (!$user) {
            return null;
        }

        $this->userHydrator->setParam('embedChannel');
        $this->userHydrator->setParam('linkBlock');
        $this->userHydrator->setParam('linkFavorite');
        $this->userHydrator->setParam('linkFollow');
        $this->userHydrator->setParam('linkMod');

        return $this->userHydrator->buildEntity($user);
    }

    public function fetchAll($params)
    {
        $select = new Select('user');

        $this->userHydrator->setParam('linkChannel');
        $this->userHydrator->setParam('linkTeam');

        $hydratingResultSet = new HydratingResultSet(
            $this->userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->userModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new UserCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchBlockedUsers($params)
    {
        $where = new Where();
        $where->equalTo('block.user_id', $params['user_id']);

        $select = new Select('user');
        $select->join('block', 'block.blocked_user_id = user.user_id', array(), 'inner');
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

        $collection = new BlockCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByChannel($channelId)
    {
        $user = $this->userModel->fetchByChannel($channelId);
        if (!$user) {
            return null;
        }

        $this->userHydrator->setParam('embedChannel');

        return $this->userHydrator->buildEntity($user);
    }

    public function fetchFavorites($params)
    {
        $where = new Where();
        $where->equalTo('favorite.user_id', $params['user_id']);

        $select = new Select('video');
        $select->join('favorite', 'favorite.video_id = video.video_id', array(), 'inner');
        $select->where($where);

        $hydratingResultSet = new HydratingResultSet(
            $this->videoHydrator,
            new Video()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->videoModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new FavoriteCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchFollows($params)
    {
        $where = new Where();
        $where->equalTo('follow.user_id', $params['user_id']);

        $select = new Select('channel');
        $select->join('follow', 'follow.channel_id = channel.channel_id', array(), 'inner');
        $select->where($where);

        $hydratingResultSet = new HydratingResultSet(
            $this->channelHydrator,
            new Channel()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->channelModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new FollowCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchMods($params)
    {
        $where = new Where();
        $where->equalTo('mod.user_id', $params['user_id']);

        $select = new Select('chat');
        $select->join('mod', 'mod.chat_id = chat.chat_id', array(), 'inner');
        $select->where($where);

        $hydratingResultSet = new HydratingResultSet(
            $this->chatHydrator,
            new Chat()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->chatModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new ModCollection($paginatorAdapter);
        return $collection;
    }

    public function update($id, $data)
    {
        // if we have an updated logo
        if (array_key_exists('logo', $data)) {
            $data->logo = '//'.str_replace('api', 'static', $_SERVER['SERVER_NAME']).'/user/logo/'.$id.'.png';
        }

        $user = $this->userModel->update($id, $data);
        if (!$user) {
            return null;
        }

        return $user;
    }
}
