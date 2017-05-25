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

namespace UserTest\V1\Service;

use stdClass;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class UserServiceTest extends AbstractControllerTestCase
{
    private $serviceManager;

    public function setUp()
    {
        $this->setApplicationConfig(
            include './config/tests.config.php'
        );
        parent::setUp();
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(true);
    }

    public function testClassType()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $this->assertInstanceOf('User\V1\Service\UserService', $userService);
    }

    public function testFetchAll()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userCollection = $userService->fetchAll();

        $this->assertInstanceOf('User\V1\Rest\User\UserCollection', $userCollection);
        $this->assertTrue(0 < $userCollection->getTotalItemCount());

        $userEntity = $userCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $userEntity);
    }

    public function testFetch()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $userEntity = $userService->fetch($userId);

        $this->assertInstanceOf('ZF\Hal\Entity', $userEntity);
        $this->assertEquals($userId, $userEntity->entity->user_id);
    }

    public function testFetchInvalidUser()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $userEntity = $userService->fetch($userId);

        $this->assertNull($userEntity);
    }

    public function testUpdate()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $data = new stdClass();
        $data->bio = 'Test';
        $data->password = 'test';
        $userEntity = $userService->update($userId, $data);

        $this->assertInstanceOf('ZF\Hal\Entity', $userEntity);
        $this->assertEquals($userId, $userEntity->entity->user_id);
        $this->assertEquals($data->bio, $userEntity->entity->bio);
    }

    public function testUpdateInvalidUser()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $data = new stdClass();
        $data->bio = 'Test';
        $userEntity = $userService->update($userId, $data);

        $this->assertNull($userEntity);
    }

    public function testFetchBlockedUsers()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $blockedUserCollection = $userService->fetchBlockedUsers(array(
            'user_id' => $userId
        ));

        $this->assertInstanceOf('User\V1\Rest\Block\BlockCollection', $blockedUserCollection);
    }

    public function testFetchByChannel()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $userEntity = $userService->fetchByChannel($channelId);

        $this->assertInstanceOf('ZF\Hal\Entity', $userEntity);
        $this->assertEquals($userId, $userEntity->entity->user_id);
    }

    public function testFetchByInvalidChannel()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid channel id
        $userEntity = $userService->fetchByChannel($channelId);

        $this->assertNull($userEntity);
    }

    public function testFetchFavorites()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $favoriteCollection = $userService->fetchFavorites(array(
            'user_id' => $userId
        ));

        $this->assertInstanceOf('User\V1\Rest\Favorite\FavoriteCollection', $favoriteCollection);
    }

    public function testFetchFollows()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $followCollection = $userService->fetchFollows(array(
            'user_id' => $userId
        ));

        $this->assertInstanceOf('User\V1\Rest\Follow\FollowCollection', $followCollection);
    }

    public function testFetchMods()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $modCollection = $userService->fetchMods(array(
            'user_id' => $userId
        ));

        $this->assertInstanceOf('User\V1\Rest\Mod\ModCollection', $modCollection);
    }

    public function testFetchTeams()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $teamCollection = $userService->fetchTeams(array(
            'user_id' => $userId
        ));

        $this->assertInstanceOf('User\V1\Rest\Team\TeamCollection', $teamCollection);
    }

    public function testIsOwner()
    {
        $userService = $this->serviceManager->get('User\V1\Service\UserService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $isOwner = $userService->isOwner($userId, $userId);

        $this->assertTrue($isOwner);

        $invalidUserId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $isOwner = $userService->isOwner($userId, $invalidUserId);

        $this->assertFalse($isOwner);
    }
}
