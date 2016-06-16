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
use User\V1\Rest\Team\TeamCollection;
use User\V1\Rest\User\UserCollection;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;

class UserService
{
    private $serviceManager;

    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function fetch($userId)
    {
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');
        $userHydrator = $this->serviceManager->get('Application\Hydrator\User\UserHydrator');

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
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');
        $userHydrator = $this->serviceManager->get('Application\Hydrator\User\UserHydrator');

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

    public function update($userId, $data)
    {
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');
        $userHydrator = $this->serviceManager->get('Application\Hydrator\User\UserHydrator');

        // if we have an updated logo
        if (array_key_exists('logo', $data)) {
            // TODO: process update image
        }

        // if we have an updated password, crypt it
        if (property_exists($data, 'password')) {
            $bcryt = new Bcrypt();
            $data->password = $bcryt->create($data->password);
        }

        $userModel->update($userId, (array) $data);

        $user = $userModel->fetch($userId);
        if (!$user) {
            return null;
        }
        return $userHydrator->buildEntity($user);
    }

    public function fetchBlockedUsers($params)
    {
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');
        $userHydrator = $this->serviceManager->get('Application\Hydrator\User\UserHydrator');

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
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');
        $userHydrator = $this->serviceManager->get('Application\Hydrator\User\UserHydrator');

        $user = $userModel->fetchByChannel($channelId);
        if (!$user) {
            return null;
        }

        $userHydrator->setParam('embedChannel', true);

        return $userHydrator->buildEntity($user);
    }

    public function fetchFavorites($params)
    {
        $videoModel = $this->serviceManager->get('Application\Database\Video\VideoModel');
        $videoHydrator = $this->serviceManager->get('Application\Hydrator\Video\VideoHydrator');

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
        $channelModel = $this->serviceManager->get('Application\Database\CHannel\CHannelModel');
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\CHannel\CHannelHydrator');

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
        $chatModel = $this->serviceManager->get('Application\Database\Chat\ChatModel');
        $chatHydrator = $this->serviceManager->get('Application\Hydrator\Chat\ChatHydrator');

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
        $teamModel = $this->serviceManager->get('Application\Database\Team\TeamModel');
        $teamHydrator = $this->serviceManager->get('Application\Hydrator\Team\TeamHydrator');

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

    public function isOwner($userId, $identityUserId)
    {
        return $userId === $identityUserId;
    }
}
