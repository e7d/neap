<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\User;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class UserModelTest extends AbstractControllerTestCase
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
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');

        $this->assertInstanceOf('Application\Database\User\UserModel', $userModel);
    }

    public function testGetTableGateway()
    {
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');

        $tableGateway = $userModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testGetSqlSelect()
    {
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');
        $select = $userModel->getSqlSelect();

        $this->assertInstanceOf('Zend\Db\Sql\Select', $select);
        $this->assertEquals('SELECT "user".* FROM "user"', $select->getSqlString());
    }

    public function testFetch()
    {
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $user = $userModel->fetch($userId);
        $this->assertInstanceOf('Application\Database\User\User', $user);
        $this->assertEquals($userId, $user->user_id);

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $user = $userModel->fetch($userId);
        $this->assertNull($user);
    }

    public function testFetchByChannel()
    {
        $userModel = $this->serviceManager->get('Application\Database\User\UserModel');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $user = $userModel->fetchByChannel($channelId);
        $this->assertInstanceOf('Application\Database\User\User', $user);
        $this->assertEquals($userId, $user->user_id);

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $user = $userModel->fetchByChannel($channelId);
        $this->assertNull($user);
    }
}
