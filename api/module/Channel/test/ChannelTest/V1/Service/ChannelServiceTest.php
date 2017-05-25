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

        $channelCollection = $channelService->fetchAll();

        $this->assertInstanceOf('Channel\V1\Rest\Channel\ChannelCollection', $channelCollection);
        $this->assertTrue(0 < $channelCollection->getTotalItemCount());

        $channelEntity = $channelCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
    }

    public function testFetch()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channelEntity = $channelService->fetch($channelId);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity->channel_id);
    }

    public function testFetchInvalidChannel()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid channel id
        $channelEntity = $channelService->fetch($channelId);

        $this->assertNull($channelEntity);
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
        $this->assertEquals($channelId, $channelEntity->entity->channel_id);
        $this->assertEquals($data['topic'], $channelEntity->entity->topic);
    }

    public function testUpdateInvalidChannel()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid channel id
        $data = array(
            'topic' => 'Test'
        );
        $channelEntity = $channelService->update($channelId, $data);

        $this->assertNull($channelEntity);
    }

    public function testFetchByUser()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $channelEntity = $channelService->fetchByUser($userId);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity->channel_id);
        $this->assertFalse(isset($channelEntity->entity->stream_key));
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
        $this->assertEquals($channelId, $channelEntity->entity->channel_id);
        $this->assertTrue(isset($channelEntity->entity->stream_key));
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
        $followerCollection = $channelService->fetchFollowers(array(
            'channel_id' => $channelId
        ));

        $this->assertInstanceOf('Channel\V1\Rest\Follow\FollowCollection', $followerCollection);
    }

    public function testFetchPanels()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55f'; // Jax channel id
        $panelCollection = $channelService->fetchPanels(array(
            'channel_id' => $channelId
        ));

        $this->assertInstanceOf('Channel\V1\Rest\Panel\PanelCollection', $panelCollection);
    }

    public function testFetchVideos()
    {
        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55f'; // Jax channel id
        $videoCollection = $channelService->fetchVideos(array(
            'channel_id' => $channelId
        ));

        $this->assertInstanceOf('Channel\V1\Rest\Video\VideoCollection', $videoCollection);
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
