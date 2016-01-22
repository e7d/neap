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
        $channelModel = $this->serviceManager->get('Application\Database\Channel\ChannelModel');

        // Test buildEntity without params

        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channel = $channelModel->fetch('23a057b7-a5b2-48da-ae73-6fd130e8c55e');
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('self'));
        $this->assertFalse(array_key_exists('stream_key', $channelEntity->entity));

        // Test buildEntity with 'keepStreamKey' param

        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channel = $channelModel->fetch('23a057b7-a5b2-48da-ae73-6fd130e8c55e');
        $channelHydrator->setParam('keepStreamKey');
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertTrue(array_key_exists('stream_key', $channelEntity->entity));

        // Test buildEntity with 'embedUser' param

        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channel = $channelModel->fetch('23a057b7-a5b2-48da-ae73-6fd130e8c55e');
        $channelHydrator->setParam('embedUser');
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertFalse(array_key_exists('user_id', $channelEntity->entity));
        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity->entity['user']);

        // Test buildEntity with 'embedLiveStream' param

        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channel = $channelModel->fetch('23a057b7-a5b2-48da-ae73-6fd130e8c55e');
        $channelHydrator->setParam('embedLiveStream');
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity->entity['stream']);

        // Test buildEntity with 'linkUser' param

        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channel = $channelModel->fetch('23a057b7-a5b2-48da-ae73-6fd130e8c55e');
        $channelHydrator->setParam('linkUser');
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertFalse(array_key_exists('user_id', $channelEntity->entity));
        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('user'));

        // Test buildEntity with 'linkLiveStream' param

        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channel = $channelModel->fetch('23a057b7-a5b2-48da-ae73-6fd130e8c55e');
        $channelHydrator->setParam('linkLiveStream');
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('stream'));

        // Test buildEntity with 'linkVideos' param

        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channel = $channelModel->fetch('23a057b7-a5b2-48da-ae73-6fd130e8c55e');
        $channelHydrator->setParam('linkVideos');
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('videos'));

        // Test buildEntity with 'linkChat' param

        $channelHydrator = $this->serviceManager->get('Application\Hydrator\Channel\ChannelHydrator');
        $channel = $channelModel->fetch('23a057b7-a5b2-48da-ae73-6fd130e8c55e');
        $channelHydrator->setParam('linkChat');
        $channelEntity = $channelHydrator->buildEntity($channel);

        $this->assertFalse(array_key_exists('chat_id', $channelEntity->entity));
        $this->assertInstanceOf('ZF\Hal\Link\Link', $channelEntity->getLinks()->get('chat'));
    }
}
