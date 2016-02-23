<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ChannelTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ChannelServiceTest extends AbstractControllerTestCase
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
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $this->assertInstanceOf('Channel\V1\Service\ChannelService', $channelService);
    }

    public function testFetchAll()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelsCollection = $channelService->fetchAll();

        $this->assertInstanceOf('Channel\V1\Rest\Channel\ChannelCollection', $channelsCollection);
        $this->assertCount(10, $channelsCollection->getCurrentItems());
        $this->assertEquals(1312, $channelsCollection->getTotalItemCount());

        $channelEntity = $channelsCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
    }

    public function testFetch()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channelEntity = $channelService->fetch($channelId);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity['channel_id']);
    }

    public function testUpdate()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $data = array(
            'topic' => 'Test'
        );
        $channelEntity = $channelService->update($channelId, $data);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity['channel_id']);
        $this->assertEquals($data['topic'], $channelEntity->entity['topic']);
    }

    public function testFetchInvalidChannel()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid channel id
        $channelEntity = $channelService->fetch($channelId);
        $this->assertNull($channelEntity);
    }

    public function testFetchByUser()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $channelEntity = $channelService->fetchByUser($userId);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity['channel_id']);
        $this->assertFalse(array_key_exists('stream_key', $channelEntity->entity));
    }

    public function testFetchByUserWithStreamKey()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $channelEntity = $channelService->fetchByUser($userId, array(
            'stream_key' => true
        ));

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity['channel_id']);
        $this->assertTrue(array_key_exists('stream_key', $channelEntity->entity));
    }

    public function testFetchByInvalidUser()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $channelEntity = $channelService->fetchByUser($userId);

        $this->assertNull($channelEntity);
    }

    public function testFetchFollowers()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55f'; // Jax channel id
        $followCollection = $channelService->fetchFollowers(array(
            'channel_id' => $channelId
        ));

        $this->assertInstanceOf('Channel\V1\Rest\Follow\FollowCollection', $followCollection);
    }

    public function testFetchPanels()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55f'; // Jax channel id
        $followCollection = $channelService->fetchPanels(array(
            'channel_id' => $channelId
        ));

        $this->assertInstanceOf('Channel\V1\Rest\Panel\PanelCollection', $followCollection);
    }

    public function testFetchVideos()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55f'; // Jax channel id
        $followCollection = $channelService->fetchVideos(array(
            'channel_id' => $channelId
        ));

        $this->assertInstanceOf('Channel\V1\Rest\Video\VideoCollection', $followCollection);
    }

    public function testIsOwner()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $isOwner = $channelService->isOwner($channelId, $userId);

        $this->assertTrue($isOwner);

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $isOwner = $channelService->isOwner($channelId, $userId);

        $this->assertFalse($isOwner);
    }
}
