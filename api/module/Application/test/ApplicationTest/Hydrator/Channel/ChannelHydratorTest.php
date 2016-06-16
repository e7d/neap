<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Hydrator\Channel;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ChannelHydratorTest extends AbstractControllerTestCase
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
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');

        $this->assertInstanceOf('Application\Hydrator\Channel\ChannelHydrator', $channelHydrator);
    }

    public function testBuildEntity()
    {
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('self'));
        $this->assertFalse(isset($channelEntity->entity->stream_key));
    }

    public function testBuildEntityWithKeepStreamKey()
    {
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $channelHydrator->setParam('keepStreamKey', true);
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertTrue(isset($channelEntity->entity->stream_key));
    }

    public function testBuildEntityWithEmbedUser()
    {
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $channelHydrator->setParam('embedUser', true);
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity->entity->user);
    }

    public function testBuildEntityWithEmbedLiveStream()
    {
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $channelHydrator->setParam('embedLiveStream', true);
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity->entity->stream);
    }

    public function testBuildEntityWithLinkUser()
    {
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $channelHydrator->setParam('linkUser', true);
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('user'));
    }

    public function testBuildEntityWithLinkLiveStream()
    {
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $channelHydrator->setParam('linkLiveStream', true);
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('stream'));
    }

    public function testBuildEntityWithLinkVideos()
    {
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $channelHydrator->setParam('linkVideos', true);
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('videos'));
    }

    public function testBuildEntityWithLinkChat()
    {
        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channel = $channelModel->fetch($channelId);
        $channelHydrator->setParam('linkChat', true);
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('chat'));
    }
}
