<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace User\V1\Service;

use Application\Database\Channel\Channel;
use Application\Database\Chat\Chat;
use Application\Database\Team\Team;
use Application\Database\User\User;
use Application\Database\Video\Video;
use User\V1\Rest\Block\BlockCollection;
use User\V1\Rest\Favorite\FavoriteCollection;
use User\V1\Rest\Follow\FollowCollection;
use User\V1\Rest\Mod\ModCollection;
use Team\V1\Rest\Team\TeamCollection;
use User\V1\Rest\User\UserCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;

class UserService
{
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function fetch($userId)
    {
        $userModel = $this->services->get('Application\Database\User\UserModel');
        $userHydrator = $this->services->get('Application\Hydrator\User\UserHydrator');

        $user = $userModel->fetch($userId);
        if (!$user) {
            return null;
        }

        $userHydrator->setParam('embedChannel', true);
        $userHydrator->setParam('linkBlock', true);
        $userHydrator->setParam('linkFavorite', true);
        $userHydrator->setParam('linkFollow', true);
        $userHydrator->setParam('linkMod', true);
        $userHydrator->setParam('linkTeams', true);

        return $userHydrator->buildEntity($user);
    }

    public function fetchAll($params = [])
    {
        $userModel = $this->services->get('Application\Database\User\UserModel');
        $userHydrator = $this->services->get('Application\Hydrator\User\UserHydrator');

        $select = $userModel->getSqlSelect();

        $userHydrator->setParam('linkChannel', true);

        $hydratingResultSet = new HydratingResultSet(
            $userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $userModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new UserCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchBlockedUsers($params)
    {
        $userModel = $this->services->get('Application\Database\User\UserModel');
        $userHydrator = $this->services->get('Application\Hydrator\User\UserHydrator');

        $select = $userModel->selectBlocksByUser($params['user_id']);

        $hydratingResultSet = new HydratingResultSet(
            $userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $userModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        return new BlockCollection($paginatorAdapter);
    }

    public function fetchByChannel($channelId)
    {
        $userModel = $this->services->get('Application\Database\User\UserModel');
        $userHydrator = $this->services->get('Application\Hydrator\User\UserHydrator');

        $user = $userModel->fetchByChannel($channelId);
        if (!$user) {
            return null;
        }

        $userHydrator->setParam('embedChannel', true);

        return $userHydrator->buildEntity($user);
    }

    public function fetchFavorites($params)
    {
        $videoModel = $this->services->get('Application\Database\Video\VideoModel');
        $videoHydrator = $this->services->get('Application\Hydrator\Video\VideoHydrator');

        $select = $videoModel->selectFavoritesByUser($params['user_id']);

        $hydratingResultSet = new HydratingResultSet(
            $videoHydrator,
            new Video()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $videoModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        return new FavoriteCollection($paginatorAdapter);
    }

    public function fetchFollows($params)
    {
        $channelModel = $this->services->get('Application\Database\CHannel\CHannelModel');
        $channelHydrator = $this->services->get('Application\Hydrator\CHannel\CHannelHydrator');

        $select = $channelModel->selectFollowsByUser($params['user_id']);

        $hydratingResultSet = new HydratingResultSet(
            $channelHydrator,
            new Channel()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $channelModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        return new FollowCollection($paginatorAdapter);
    }

    public function fetchMods($params)
    {
        $chatModel = $this->services->get('Application\Database\Chat\ChatModel');
        $chatHydrator = $this->services->get('Application\Hydrator\Chat\ChatHydrator');

        $select = $chatModel->selectModsByUser($params['user_id']);

        $hydratingResultSet = new HydratingResultSet(
            $chatHydrator,
            new Chat()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $chatModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        return new ModCollection($paginatorAdapter);
    }

    public function fetchTeams($params)
    {
        $teamModel = $this->services->get('Application\Database\Team\TeamModel');
        $teamHydrator = $this->services->get('Application\Hydrator\Team\TeamHydrator');

        $select = $teamModel->selectByUser($params['user_id']);

        $hydratingResultSet = new HydratingResultSet(
            $teamHydrator,
            new Team()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $teamModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        return new TeamCollection($paginatorAdapter);
    }

    public function patch($userId, $data)
    {
        $userModel = $this->services->get('Application\Database\User\UserModel');

        // if we have an updated logo
        if (array_key_exists('logo', $data)) {
            // TODO: process update image
        }

        if (!$userModel->update($userId, $data)) {
            // TODO: error handling
            throw new \Exception();
        }
    }

    public function update($userId, $data)
    {
        $this->patch($userId, $data);
        return $this->fetch($userId);
    }
}
