<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\Channel;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ChannelModelTest extends AbstractControllerTestCase
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
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $this->assertInstanceOf('Application\Database\Channel\ChannelModel', $channelModel);
    }

    public function testGetTableGateway()
    {
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $tableGateway = $channelModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testGetSqlSelect()
    {
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');
        $select = $channelModel->getSqlSelect();

        $this->assertInstanceOf('Zend\Db\Sql\Select', $select);
        $this->assertEquals('SELECT "channel".* FROM "channel"', $select->getSqlString());
    }

    public function testFetch()
    {
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $this->assertInstanceOf('Application\Database\Channel\Channel', $channel);
        $this->assertEquals($channelId, $channel->channel_id);

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid channel id
        $channel = $channelModel->fetch($channelId);
        $this->assertNull($channel);
    }

    public function testFetchByStreamKey()
    {
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $streamKey = 'live_1b0f5864_d637993a8bf849b3c8aad171'; // Jax channel stream key
        $channel = $channelModel->fetchByStreamKey($streamKey);
        $this->assertInstanceOf('Application\Database\Channel\Channel', $channel);
        $this->assertEquals($channelId, $channel->channel_id);

        $streamKey = 'live_00000000_000000000000000000000000'; // Invalid stream key
        $channel = $channelModel->fetchByStreamKey($streamKey);
        $this->assertNull($channel);
    }

    public function testFetchByUser()
    {
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $channel = $channelModel->fetchByUser($userId);
        $this->assertInstanceOf('Application\Database\Channel\Channel', $channel);
        $this->assertEquals($channelId, $channel->channel_id);

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $channel = $channelModel->fetchByUser($userId);
        $this->assertNull($channel);
    }

    public function testFetchFollowByUser()
    {
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $follows = $channelModel->fetchFollowsByUser($userId);
        $this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $follows);
        $this->assertEquals(70, $follows->count());

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $follows = $channelModel->fetchFollowsByUser($userId);
        $this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $follows);
        $this->assertEquals(0, $follows->count());
    }

    public function testUpdate()
    {
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $data = array(
            'logo' => 'https://gravatar.com/avatar/' . md5('testUpdate') . '?s=128&d=identicon'
        );

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $updatedRows = $channelModel->update($channelId, $data);
        $this->assertEquals(1, $updatedRows);

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid channel id
        $updatedRows = $channelModel->update($channelId, $data);
        $this->assertEquals(0, $updatedRows);
    }
}
